<?php

require_once '../setup.php';

// Controllers
require_once __DIR__.'/../app/controllers/index.php';
require_once __DIR__.'/../app/controllers/users.php';
require_once __DIR__.'/../app/controllers/groups.php';
require_once __DIR__.'/../app/controllers/permissions.php';
require_once __DIR__.'/../app/controllers/policies.php';

$app->run();
