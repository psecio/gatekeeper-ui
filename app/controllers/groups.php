<?php
use \Psecio\Gatekeeper\Gatekeeper as g;

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
			'permissions' => $group->permissions->toArray(true)
		);
		$view->render('groups/view.php', $data);
	});
});