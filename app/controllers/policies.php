<?php
use \Psecio\Gatekeeper\Gatekeeper as g;

$app->group('/policies', function() use ($app, $view) {

	$app->get('/', function() use ($app, $view) {
		$view->render('policies/index.php');
	});
});