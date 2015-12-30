<?php

use Lemon\Deploy\Task\Context;

/**
 * Require autoload.php file
 */
$loaded = false;
foreach (['/../../autoload.php', '/../vendor/autoload.php'] as $file) {
    if (file_exists(__DIR__ . $file)) {
        require_once __DIR__ . $file;
        $loaded = true;
        break;
    }
}
if (!$loaded) {
    die(
        'You need to set up the project dependencies using the following commands:' . PHP_EOL .
        'wget http://getcomposer.org/composer.phar' . PHP_EOL .
        'php composer.phar install' . PHP_EOL
    );
}
unset($loaded);

// constants
define('DEPLOY_BIN', __FILE__);

$filename = dirname(__DIR__) . '/composer.json';
$cg       = json_decode(file_get_contents($filename), true);

$app = new \Lemon\Deploy\App($cg['name'], $cg['version']);

$app->task('foo', function(Context $context) {
    echo 'Task foo';
})->desc('Task foo');

$app->task('bar', function(Context $context) {
    echo 'Task bar';
})->desc('Task bar');

$app->group('deploy', [
    'foo',
    'bar',
    'foo',
])->desc('Task deploy');

$app->before('bar', function($e) {
    echo $e->getName() . ' is fired';
});

$app->after('deploy', function($e) {
    echo $e->getName() . ' is fired';
});

$app->run();
