<?php
use \Psecio\Gatekeeper\Gatekeeper as g;

$app->group('/permission', function() use ($app, $view) {

	$app->get('/', function() use ($app, $view) {
		$permissions = g::findPermissions();
		$view->render('json.php', $permissions->toArray(true));
	});
	$app->get('/:id', function($id) use ($app, $view) {
		$perm = (is_numeric($id)) ? g::findPermissionById($id) : g::findPermissionByName($id);
		$view->render('json.php', $perm->toArray());
	});
});

// Pages
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