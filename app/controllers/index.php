<?php

$app->group('/', function() use ($app, $view) {

	$app->get('/', function() use ($app, $view) {
		echo $view->render('index/index.php');
	});
});