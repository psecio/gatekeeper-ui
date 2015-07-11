<?php
use \Psecio\Gatekeeper\Gatekeeper as g;

$app->group('/permission', function() use ($app, $view) {

	$app->get('/', function() use ($app, $view) {
		$permissions = g::findPermissions();
		$perms = [];
		foreach ($permissions as $permission) {
			error_log(print_r($permission->isExpired(), true));
			$perm = $permission->toArray();
			$perm['expired'] = $permission->isExpired();
			$perms[] = $perm;
		}
		$view->render('json.php', $perms);
	});
	$app->get('/:id', function($id) use ($app, $view) {
		$perm = (is_numeric($id)) ? g::findPermissionById($id) : g::findPermissionByName($id);
		$view->render('json.php', $perm->toArray());
	});
	$app->get('/:id/group', function($id) use ($app, $view) {
		$groups = g::findPermissionById($id)->groups;
		$view->render('json.php', $groups->toArray(true));
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

	$app->get('/edit/:permId', function($permId) use ($app, $view) {
		$permission = g::findPermissionById($permId);
		$data = [
			'permission' => $permission->toArray()
		];
		$view->render('permissions/edit.php', $data);
	});
	$app->post('/edit/:permId', function($permId) use ($app, $view) {
		$permission = g::findPermissionById($permId);
		$data = ['success' => true];
		$post = $app->request->post();
		$ds = g::getDatasource();

		$permission->name = $post['name'];
		$permission->description = $post['description'];
		try {
			$ds->save($permission);
		} catch (\Exception $e) {
			$data['success'] = false;
		}

		$data['permission'] = $permission->toArray();
		$view->render('permissions/edit.php', $data);
	});

	$app->get('/view/:name', function($perm) use ($app, $view) {
		$permission = (is_numeric($perm))
			? g::findPermissionById($perm) : g::findPermissionByName($perm);

		$data = [
			'permission' => $permission->toArray(),
			'groups' => $permission->groups->toArray(true)
		];

		$view->render('permissions/view.php', $data);
	});
});