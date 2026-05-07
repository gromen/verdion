<?php

namespace Deployer;

require 'recipe/common.php';

set('application', 'verdion');
set('repository', 'git@github.com:gromen/verdion.git');
set('git_tty', false);
set('keep_releases', 3);
set('writable_mode', 'chmod');

set('shared_files', ['.env']);
set('shared_dirs', ['web/app/uploads']);
set('writable_dirs', ['web/app/uploads']);

host('staging')
    ->setHostname('verdion.smarthost.pl')
    ->setPort(5739)
    ->setRemoteUser('verdion')
    ->setIdentityFile('~/.ssh/verdion_deploy')
    ->setDeployPath('/home/verdion/public_html/staging')
    ->set('branch', 'develop')
    ->set('site_url', 'https://staging.verdion.pl');

host('production')
    ->setHostname('verdion.smarthost.pl')
    ->setPort(5739)
    ->setRemoteUser('verdion')
    ->setIdentityFile('~/.ssh/verdion_deploy')
    ->setDeployPath('/home/verdion/verdion.pl')
    ->set('branch', 'main')
    ->set('site_url', 'https://verdion.pl');

task('theme:vendors', function () {
    run('cd {{release_path}}/web/app/themes/verdion && {{bin/composer}} install --no-dev --optimize-autoloader --no-interaction');
});

task('theme:upload_assets', function () {
    $localThemePath = __DIR__ . '/web/app/themes/verdion';
    upload($localThemePath . '/public/', '{{release_path}}/web/app/themes/verdion/public/');
    run('chmod -R u+rwX,go+rX {{release_path}}/web/app/themes/verdion/public');
});

task('php:reload', function () {
    run('pkill -9 -u $(whoami) -f "^lsphp$" 2>/dev/null || true');
});

task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'theme:vendors',
    'theme:upload_assets',
    'deploy:publish',
    'php:reload',
]);

after('deploy:failed', 'deploy:unlock');

// ─── Maintenance landing (verdion.pl pre-launch) ───────────────────────────

host('production-maintenance')
    ->setHostname('verdion.smarthost.pl')
    ->setPort(5739)
    ->setRemoteUser('verdion')
    ->setIdentityFile('~/.ssh/verdion_deploy')
    ->set('deploy_path', '/home/verdion/verdion.pl-maintenance');

task('maintenance:upload', function () {
    $localPath = __DIR__ . '/maintenance/';
    $remotePath = '/home/verdion/verdion.pl-maintenance/';

    upload($localPath, $remotePath, [
        'options' => ['--delete', '--exclude=.DS_Store'],
    ]);

    run("chmod 644 {$remotePath}.htaccess {$remotePath}index.html");
    run("find {$remotePath} -type d -exec chmod 755 {} \\;");
})->desc('Upload static maintenance landing to production-maintenance host');
