# Deployment Guide

Stack: Bedrock + Sage · Deployer 8 · GitHub Actions · Smarthost shared hosting

## Environments

| Environment | Domain | Branch | Trigger |
|---|---|---|---|
| Staging | staging.verdion.pl | `develop` | Auto on push |
| Production | verdion.pl | `main` | Manual (`workflow_dispatch`) |

Composer and CI expect **PHP 8.4+** (Symfony 8 dev toolchain). Locally, set `.ddev/config.yaml` to `php_version: "8.4"` (the `.ddev/` directory is not in this repo) and run `ddev restart`.

## Server Structure (Deployer atomic releases)

```
/home/verdion/staging.verdion.pl/     ← staging deploy path
├── current -> releases/20260507…     ← symlink (atomic switch)
├── releases/
│   ├── 20260507120000/
│   │   └── web/                      ← Bedrock web dir
│   └── …
└── shared/
    ├── .env                          ← never in git
    └── web/app/uploads/              ← persistent media
```

Production uses `/home/verdion/verdion.pl/` with the same structure.

## One-Time Server Setup

### 1. Create deploy directories

```bash
ssh verdion-staging
mkdir -p ~/staging.verdion.pl/shared
mkdir -p ~/verdion.pl/shared
```

### 2. Create .env files on server

Staging (`~/staging.verdion.pl/shared/.env`):

```dotenv
DB_NAME='verdion_stg'
DB_USER='verdion_mgromek'
DB_PASSWORD='your_password'
DB_HOST='localhost'

WP_ENV='staging'
WP_HOME='https://staging.verdion.pl'
WP_SITEURL="${WP_HOME}/wp"

AUTH_KEY='…'
SECURE_AUTH_KEY='…'
LOGGED_IN_KEY='…'
NONCE_KEY='…'
AUTH_SALT='…'
SECURE_AUTH_SALT='…'
LOGGED_IN_SALT='…'
NONCE_SALT='…'
```

Generate fresh salts: https://roots.io/salts.html

Production (`~/verdion.pl/shared/.env`) — same structure, `WP_ENV='production'`, production DB creds.

### 3. First manual deploy (verify hosting)

On your local machine:

```bash
vendor/bin/dep deploy staging
```

After successful deploy, the `current` symlink points to `current/web` (Bedrock).

### 4. Change Document Root in cPanel

In cPanel → Domains → staging.verdion.pl → change Document Root to:

```
/home/verdion/staging.verdion.pl/current/web
```

Repeat for production → verdion.pl → `/home/verdion/verdion.pl/current/web`

### 5. Import database

```bash
# On local DDEV — export
ddev export-db --file=dump.sql.gz

# Upload to server
scp -P 5739 dump.sql.gz verdion@verdion.smarthost.pl:~/

# On server — import
ssh verdion-staging
cd ~
gunzip dump.sql.gz
mysql -u verdion_mgromek -p verdion_stg < dump.sql
```

Run search-replace for URLs:

```bash
wp search-replace 'https://verdion.ddev.site' 'https://staging.verdion.pl' --path=/home/verdion/staging.verdion.pl/current/web/wp
```

## GitHub Secrets Setup

In GitHub → Settings → Secrets and variables → Actions, add:

| Secret | Value |
|---|---|
| `SSH_PRIVATE_KEY` | Contents of `~/.ssh/verdion_deploy` (private key) |
| `SSH_KNOWN_HOSTS` | Output of `ssh-keyscan -p 5739 verdion.smarthost.pl` |

### Get known hosts fingerprint

```bash
ssh-keyscan -p 5739 verdion.smarthost.pl
```

Copy full output and paste as `SSH_KNOWN_HOSTS` secret.

## GitHub Environment: production

Go to GitHub → Settings → Environments → New environment → `production`.

Add **Required reviewers** (your GitHub username) to require manual approval before production deploys run.

## Branch Protection (main)

Go to GitHub → Settings → Branches → Add rule for `main`:

- [x] Require a pull request before merging
- [x] Require approvals (1)
- [x] Require status checks to pass (add deploy-staging job)
- [x] Do not allow bypassing the above settings

## Deployer Commands

```bash
# Deploy to staging (manual)
vendor/bin/dep deploy staging

# Deploy to production (manual)
vendor/bin/dep deploy production

# Rollback staging to previous release
vendor/bin/dep rollback staging

# Run a command on staging
vendor/bin/dep run staging -- "wp plugin list --path=/home/verdion/staging.verdion.pl/current/web/wp"
```

## Maintenance Landing (verdion.pl pre-launch)

Before the WordPress production site goes live, `verdion.pl` serves a static "coming soon" page from a separate directory — independent of PHP, WordPress, or the database.

### Directory on server

```
/home/verdion/verdion.pl-maintenance/
├── index.html     ← self-contained HTML (inline CSS + SVG)
└── .htaccess      ← HTTP 503 + Retry-After + noindex headers
```

### One-time server setup

```bash
ssh -p 5739 verdion@verdion.smarthost.pl "mkdir -p ~/verdion.pl-maintenance"
```

Then upload:

```bash
vendor/bin/dep maintenance:upload production-maintenance
```

Then in **cPanel → Domains → verdion.pl** set Document Root to:

```
/home/verdion/verdion.pl-maintenance
```

### Updating the maintenance page

```bash
vendor/bin/dep maintenance:upload production-maintenance
```

### Switching to the live WordPress site

1. Deploy production WordPress: `vendor/bin/dep deploy production`
2. In cPanel → Domains → `verdion.pl`, change Document Root to:

```
/home/verdion/verdion.pl/current/web
```

3. Verify: `curl -I https://verdion.pl` → expect `HTTP/1.1 200 OK`

### Switching back to maintenance

Change Document Root back to `/home/verdion/verdion.pl-maintenance` in cPanel.

See also: [`maintenance/README.md`](maintenance/README.md)

## Staging Access Protection

The staging environment is protected by HTTP Basic Auth. The credentials are stored in the team password manager.

- **Login:** `verdion`
- **Password:** stored in team password manager (search: *verdion staging*)
- **`.htpasswd` location:** `/home/verdion/public_html/staging/shared/.htpasswd` (outside Deployer release rotation — survives atomic deploys)
- **Rules:** `web/.htaccess` — the `BEGIN Staging Protection` block activates only when `HTTP_HOST` starts with `staging.`; it is a no-op on production

### Add or change a user

```bash
ssh verdion-staging
# Add a new user (-b = password on command line, use interactively without -b for prompt)
htpasswd ~/public_html/staging/shared/.htpasswd <username>

# Or regenerate with openssl if htpasswd is not available:
HASH=$(openssl passwd -apr1 'newpassword')
echo "verdion:$HASH" > ~/public_html/staging/shared/.htpasswd
chmod 644 ~/public_html/staging/shared/.htpasswd
```

### Verify protection

```bash
# Should return 401
curl -I https://staging.verdion.pl

# Should return 200 + X-Robots-Tag: noindex, nofollow, noarchive
curl -I -u verdion:PASSWORD https://staging.verdion.pl

# Production must NOT return 401
curl -I https://verdion.pl
```

## Troubleshooting

**Permission denied (publickey)** — Check that `~/.ssh/verdion_deploy.pub` is authorized in cPanel → SSH Access → Manage Keys.

**Composer not found on server** — Deployer auto-downloads composer.phar to `.dep/` if not available globally.

**Document root shows directory listing** — cPanel docroot still points to old path. Complete step 4 above.

**Deploy locked** — A previous deploy failed and left a lock. Run `vendor/bin/dep deploy:unlock staging`.
