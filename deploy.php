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

task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'theme:vendors',
    'theme:upload_assets',
    'deploy:publish',
]);

after('deploy:failed', 'deploy:unlock');
