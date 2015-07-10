<?php
use \Psecio\Gatekeeper\Gatekeeper as g;

$app->group('/group', function() use ($app, $view) {
	$app->get('/', function() use ($app, $view) {
		$groups = g::findGroups();
		$view->render('json.php', $groups->toArray(true));
	});
	$app->post('/', function() use ($app, $view) {
		$data = json_decode($app->request->getBody(true));

		g::createGroup([
			'name' => $data->name,
			'description' => $data->description
		]);
	});
	$app->get('/:id', function($id) use ($app, $view) {
		$group = (is_numeric($id)) ? g::findGroupById($id) : g::findGroupByName($id);
		$view->render('json.php', $group->toArray());
	});
	$app->delete('/:id', function($id) use ($app, $view) {
		$group = g::findGroupById($id);
		g::deleteGroup($group);
	});
	$app->get('/:id/permission', function($groupId) use ($app, $view) {
		$permissions = g::findGroupById($groupId)->permissions;
		$view->render('json.php', $permissions->toArray(true));
	});
	$app->put('/:id/permission/:permId', function($groupId, $permId) use ($app, $view) {
		$group = g::findGroupById($groupId);
		if ($group->hasPermission($permId) === false) {
			$group->addPermission($permId);
		}
	});
	$app->delete('/:id/permission/:permId', function($groupId, $permId) use ($app, $view) {
		$group = g::findGroupById($groupId);
		$group->removePermission($permId);
	});
	$app->get('/:id/user', function($groupId) use ($app, $view) {
		$users = g::findGroupById($groupId)->users;
		$view->render('json.php', $users->toArray(true));
	});
	$app->delete('/:id/user/:userId', function($groupId, $userId) use ($app, $view) {
		$group = g::findGroupById($groupId);
		$group->removeUser($userId);
	});
	$app->put('/:id/user/:userId', function($groupId, $userId) use ($app, $view) {
		$group = g::findGroupById($groupId);
		if ($group->inGroup($userId) === false) {
			$user = g::findUserById($userId);
			$group->addUser($user);
		}
	});
});

// Pages
$app->group('/groups', function() use ($app, $view) {

	$app->get('/', function() use ($app, $view) {
		$groups = g::findGroups();
		$data = [
			'groups' => $groups->toArray(true)
		];

		$view->render('groups/index.php', $data);
	});

	$app->get('/view/:group', function($group) use ($app, $view) {
		$group = g::findGroupByName($group);
		$data = array(
			'group' => $group->toArray(),
			'permissions' => $group->permissions->toArray(true),
			'users' => $group->users->toArray(true)
		);
		$view->render('groups/view.php', $data);
	});

	$app->get('/edit/:group', function($group) use ($app, $view) {
		$group = g::findGroupByName($group);
		$data = [
			'group' => $group->toArray()
		];
		$view->render('groups/edit.php', $data);
	});
	$app->post('/edit/:group', function($group) use ($app, $view) {
		$post = $app->request->post();
		$data = ['success' => true];

		$group = g::findGroupByName($group);
		$group->name = $post['name'];
		$group->description = $post['description'];

		$ds = g::getDatasource();
		if ($ds->save($group) === false) {
			throw new \Exception('Error saving user.');
		}

		$data['group'] = $group->toArray();
		$view->render('groups/edit.php', $data);
	});

	$app->post('/add', function() use ($app, $view) {
		$data = $app->request->post();

		try {
			$result = g::createGroup(array(
				'name' => $data['name'],
    			'description' => $data['description']
			));
			if ($result === false) {
				throw new \Exception('Error creating group');
			}
		} catch (\Exception $e) {
			if (ACCEPT_JSON) { $app->response->setStatus(400); }
			$data = array(
				'message' => $e->getMessage()
			);
		}

		echo $view->render('group/add.php', $data);
	});

	$app->post('/permissions', function() use ($app, $view) {
		$idList = $app->request->post('ids');
		$groupName = $app->request->post('name');

		$group = g::findGroupByName($groupName);
		foreach ($idList as $permissionId) {
			$group->addPermission($permissionId);
		}
		// Remove any not in the list
		foreach ($group->permissions as $permission) {
			if (!in_array($permission->id, $idList)) {
				$group->removePermission($permission->id);
			}
		}

		echo $view->render('group/permissions.php');
	});

	// Return the permissions this group has
	$app->get('/permissions/:groupName', function($groupName) use ($app, $view) {
		$permissions = g::findGroupByName($groupName)->permissions;
		$data = array(
			'permissions' => $permissions->toArray(true)
		);
		echo $view->render('group/permissions.php', $data);
	});

	$app->delete('/permissions', function() use ($app, $view) {
		$groupName = $app->request->post('groupName');
		$permId = $app->request->post('permissionId');

		$group = g::findGroupByName($groupName);
		$group->removePermission($permId);

		echo $view->render('group/permissions.php');
	});

	$app->post('/users', function() use ($app, $view) {
		$idList = $app->request->post('ids');
		$groupName = $app->request->post('name');

		$group = g::findGroupByName($groupName);
		foreach ($idList as $userId) {
			$group->addUser($userId);
		}
		// Remove any not in the list
		foreach ($group->users as $user) {
			if (!in_array($user->id, $idList)) {
				$group->removeUser($user->id);
			}
		}

		echo $view->render('group/users.php');
	});
	$app->delete('/users', function() use ($app, $view) {
		$groupName = $app->request->post('groupName');
		$userId = $app->request->post('userId');

		$group = g::findGroupByName($groupName);
		$group->removeUser($userId);

		echo $view->render('group/users.php');
	});
});