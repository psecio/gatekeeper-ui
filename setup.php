<?php
use Pimple\Container;

require_once '../vendor/autoload.php';

// Custom autoloader
spl_autoload_register(function($class) {
    $path = __DIR__.'/lib/'.str_replace('\\', '/', $class).'.php';
    if (is_file($path)) {
        require_once $path;
    }
});

session_start();

$app = new \Slim\Slim();

\Psecio\Gatekeeper\Gatekeeper::init('../');
$config = \Psecio\Gatekeeper\Gatekeeper::getConfig();

$app->config(array(
	'view' => new \GatekeeperUI\View\TemplateView(),
	'templates.path' => '../templates',
	'debug' => true
));
$app->contentType('text/html; charset=utf-8');

define(
	'ACCEPT_JSON',
	strstr($app->request->headers->get('Accept'), 'application/json') !== false
);

$view = $app->view();
$view->parserExtensions = array(
    new \Slim\Views\TwigExtension(),
);
$view->parserOptions = array(
    'debug' => true
);

$di = new Container();
$di['db'] = function()
{
	$dsn = 'mysql:host='.$config['host'].';dbname='.$config['name'].';charset=UTF8';
    return new \PDO($dsn, $config['username'], $config['password']);
};

$app->di = $di;