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

	$app->get('/view/:name', function($perm) use ($app, $view) {
		$permission = (is_numeric($perm))
			? g::findPermissionById($perm) : g::findPermissionByName($perm);
		$data = $permission->toArray();

		$view->render('permissions/view.php', $data);
	});
});