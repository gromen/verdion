# Maintenance Landing — verdion.pl

Static "coming soon / maintenance" page served at `verdion.pl` before the WordPress production site launches.

## Files

| File | Purpose |
|---|---|
| `index.html` | Self-contained HTML page — all CSS inline, SVG logo inline, no JS dependencies |
| `.htaccess` | Forces HTTP 503 + `Retry-After`, sets `X-Robots-Tag: noindex`, security headers |

## Deploy

**Option A — Deployer (recommended, repeatable):**

```bash
vendor/bin/dep maintenance:upload production-maintenance
```

This uploads the `maintenance/` folder contents to `/home/verdion/verdion.pl-maintenance/` on the server.

**Option B — one-shot SCP (first-time or fallback):**

```bash
scp -P 5739 -r maintenance/. verdion@verdion.smarthost.pl:~/verdion.pl-maintenance/
```

## Server setup (one-time)

1. Create the directory on the server:

```bash
ssh -p 5739 verdion@verdion.smarthost.pl "mkdir -p ~/verdion.pl-maintenance"
```

2. Upload files (see above).

3. In **cPanel → Domains → verdion.pl**, set Document Root to:

```
/home/verdion/verdion.pl-maintenance
```

## Switching to the live WordPress site

When the production WordPress deploy is ready:

1. Run `vendor/bin/dep deploy production` to publish the Bedrock release.
2. In **cPanel → Domains → verdion.pl**, change Document Root to:

```
/home/verdion/verdion.pl/current/web
```

3. Verify with `curl -I https://verdion.pl` — expect `HTTP/1.1 200 OK`.

## Switching back to maintenance (if needed)

Change Document Root back to `/home/verdion/verdion.pl-maintenance` in cPanel.
