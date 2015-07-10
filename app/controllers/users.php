<?php
use \Psecio\Gatekeeper\Gatekeeper as g;

$app->group('/user', function() use ($app, $view) {
	$app->get('/', function() use ($app, $view) {
		$users = g::findUsers();
		$view->render('json.php', $users->toArray(true));
	});
	$app->get('/:id', function($id) use ($app, $view) {
		$user = g::findUserById($id);
		$view->render('json.php', $user->toArray());
	});
});

// Pages
$app->group('/users', function() use ($app, $view) {

	$app->get('/', function() use ($app, $view) {
		$users = g::findUsers();
		$data = array(
			'users' => $users->toArray(true)
		);

		echo $view->render('users/index.php', $data);
	});

	$app->post('/add', function() use ($app, $view) {
		$data = $app->request->post();

		try {
			// Verify the emails match
			if ($data['password'] !== $data['password-confirm']) {
				throw new \Exception('Password mismatch!');
			}

			$result = g::createUser(array(
				'username' => $data['username'],
    			'password' => $data['password'],
    			'email' => $data['email'],
    			'first_name' => $data['first-name'],
    			'last_name' => $data['last-name']
			));
			if ($result === false) {
				throw new \Exception('Error creating user');
			}
		} catch (\Exception $e) {
			if (ACCEPT_JSON) { $app->response->setStatus(400); }
			$data = array(
				'message' => $e->getMessage()
			);
		}

		echo $view->render('users/add.php', $data);
	});

	$app->get('/view/:username', function($username) use ($app, $view) {
		try {
			$user = g::findUserByUsername($username);
			$data = array(
				'user' => $user->toArray(),
				'groups' => $user->groups->toArray(true),
				'permissions' => $user->permissions->toArray(true)
			);
			echo $view->render('users/view.php', $data);

		} catch (\Exception $e) {
			if (ACCEPT_JSON) { $app->response->setStatus(404); }
			$data = array(
				'message' => 'User "'.$username.'" not found!'
			);
			echo $view->render('error/index.php', $data);
		}
	});

	$app->get('/edit/:username', function($username) use ($app, $view) {
		try {
			$user = g::findUserByUsername($username);
			$data = array(
				'user' => $user->toArray()
			);
			echo $view->render('users/edit.php', $data);

		} catch (\Exception $e) {
			if (ACCEPT_JSON) { $app->response->setStatus(404); }
			$data = array(
				'message' => 'User "'.$username.'" not found!'
			);
			echo $view->render('error/index.php', $data);
		}
	});

	$app->post('/edit/:username', function($username) use ($app, $view) {
		$post = $app->request->post();
		$data = array('success' => true);

		try {
			$user = g::findUserByUsername($username);

			$user->email = $post['email'];
			$user->firstName = $post['first-name'];
			$user->lastName = $post['last-name'];
			$user->status = $post['status'];

			$ds = g::getDatasource();
			if ($ds->save($user) === false) {
				throw new \Exception('Error saving user.');
			}
			$data['user'] = $user->toArray();
			echo $view->render('users/edit.php', $data);

		} catch (\Exception $e) {
			if (ACCEPT_JSON) { $app->response->setStatus(404); }
			$data = array(
				'message' => $e->getMessage()
			);
			echo $view->render('error/index.php', $data);
		}
	});

	$app->get('/delete/:username', function($username) use ($app, $view) {
		$data = array();
		try {
			$user = g::findUserByUsername($username);
			$ds = g::getDatasource();

			if ($ds->delete($user) === false) {
				throw new \Exception('Error deleting user.');
			}
			echo $view->render('users/delete.php', $data);

		} catch (\Exception $e) {
			if (ACCEPT_JSON) { $app->response->setStatus(404); }
			$data = array(
				'message' => $e->getMessage()
			);
			echo $view->render('error/index.php', $data);
		}
	});

	$app->get('/status/:username', function($username) use ($app, $view) {
		$user = g::findUserByUsername($username);
		($user->status === 'active') ? $user->deactivate() : $user->activate();
		$result = array(
			'status' => $user->status,
			'username' => $username
		);

		echo json_encode($result);
	});
});