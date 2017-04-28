<?php
namespace Deployer;
require 'recipe/symfony.php';
require 'recipe/symfony3.php';

// Configuration

set('ssh_type', 'native');
set('ssh_multiplexing', true);

set('repository', 'https://github.com/chazzbg/symfony-deployment.git');

add('writable_dirs', []);

// Servers

server('production', 'deployer.symfony.vagrant')
    ->user('ubuntu')
    ->identityFile('~/.ssh/chazzbg.pub','~/.ssh/chazzbg')
    ->set('deploy_path', '/var/www/deployer')
    ->pty(true);


// Tasks

desc('Restart Apache');
task('apache:restart', function () {
    run('sudo systemctl restart apache2');
});

/**
 * Migrate database
 */
task('database:migrate', function () {
    run('{{env_vars}} {{bin/php}} {{bin/console}} doctrine:schema:update --force {{console_options}}');
})->desc('Migrate database');

task('phpunit', function (){
   runLocally('{{bin/php}} bin/phpunit -c phpunit.xml.dist');
})->desc('Run tests');
after('deploy:symlink', 'apache:restart');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'database:migrate');


before('deploy','phpunit');