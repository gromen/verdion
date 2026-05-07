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
    ->setDeployPath('/home/verdion/staging.verdion.pl')
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

task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'deploy:publish',
]);

after('deploy:failed', 'deploy:unlock');
