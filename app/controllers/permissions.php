<?php
use \Psecio\Gatekeeper\Gatekeeper as g;

$app->group('/permissions', function() use ($app, $view) {

	$app->get('/', function() use ($app, $view) {
		$permissions = g::findPermissions();
		$data = [
			'permissions' => $permissions->toArray(true)
		];
		$view->render('permissions/index.php', $data);
	});
});