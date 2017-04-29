<?php
namespace Deployer;

require 'recipe/symfony3.php';

// Configuration

set('ssh_type', 'phpseclib');
set('ssh_multiplexing', true);

set('repository', 'https://github.com/chazzbg/symfony-deployment.git');

// Symfony shared dirs
set('shared_dirs', [
    'var/logs',
    'var/sessions',
]);

// Symfony writable dirs
set('writable_dirs', ['var/cache', 'var/logs', 'var/sessions']);


// Servers

server('production', 'deployer.symfony.vagrant')
    ->user('ubuntu')
    ->identityFile()
    ->set('deploy_path', '/var/www/deployer/')
    ->pty(true);


// Tasks

desc('Restart PHP-FPM service');
task('apache:restart', function () {
    run('sudo systemctl restart apache2');
});

task('phpunit', function (){
    runLocally('{{bin/php}} bin/phpunit -c phpunit.xml.dist');
})->desc('Run tests');

/**
 * Migrate database
 */
task('database:migrate', function () {
    run('{{env_vars}} {{bin/php}} {{bin/console}} doctrine:schema:update --force {{console_options}}');
})->desc('Migrate database');


before('deploy', 'phpunit');

after('deploy:symlink', 'apache:restart');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'database:migrate');
