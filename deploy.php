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

host('production')
    ->setHostname('verdion.smarthost.pl')
    ->setPort(5739)
    ->setRemoteUser('verdion')
    ->setIdentityFile('~/.ssh/verdion_deploy')
    ->setDeployPath('/home/verdion/public_html/verdion.pl')
    ->set('branch', 'main')
    ->set('site_url', 'https://verdion.pl');

task('theme:vendors', function () {
    run('cd {{release_path}}/web/app/themes/verdion && {{bin/composer}} install --no-dev --optimize-autoloader --no-interaction');
});

task('theme:upload_assets', function () {
    $localThemePath = __DIR__ . '/web/app/themes/verdion';
    upload($localThemePath . '/public/', '{{release_path}}/web/app/themes/verdion/public/', [
        'options' => ['--exclude=hot'],
    ]);
    run('chmod -R u+rwX,go+rX {{release_path}}/web/app/themes/verdion/public');
});

task('php:reload', function () {
    run('pkill -9 -u $(whoami) -f "^lsphp$" 2>/dev/null || true');
});

task('theme:cache_clear', function () {
    run('cd {{deploy_path}}/current/web/app/themes/verdion && \
        find storage/framework/cache -type f -delete 2>/dev/null || true; \
        find storage/framework/views -type f -delete 2>/dev/null || true; \
        find bootstrap/cache -name "*.php" -delete 2>/dev/null || true');
    run('cd {{deploy_path}}/current && wp acorn view:clear --path=web/wp --url={{site_url}} 2>/dev/null || true');
    run('cd {{deploy_path}}/current && wp acorn cache:clear --path=web/wp --url={{site_url}} 2>/dev/null || true');
    run('cd {{deploy_path}}/current && wp rewrite flush --hard --path=web/wp --url={{site_url}} 2>/dev/null || true');
});

task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'theme:vendors',
    'theme:upload_assets',
    'deploy:publish',
    'theme:cache_clear',
    'php:reload',
]);

after('deploy:failed', 'deploy:unlock');
