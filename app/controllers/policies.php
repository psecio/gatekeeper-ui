<?php
use \Psecio\Gatekeeper\Gatekeeper as g;

$app->group('/policy', function() use ($app, $view) {

	$app->get('/', function() use ($app, $view) {
		$policies = g::findPolicys();
		$policyList = [];
		foreach ($policies as $policy) {
			$policyList[] = $policy->toArray();
		}
		$view->render('json.php', $policyList);
	});
	$app->get('/:id', function() use ($app, $view) {

	});

});

$app->group('/policies', function() use ($app, $view) {

	$app->get('/', function() use ($app, $view) {
		$view->render('policies/index.php');
	});
});