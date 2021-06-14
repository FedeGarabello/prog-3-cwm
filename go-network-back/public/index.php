<?php

require __DIR__ . '/../autoload.php';

$rootPath = realpath(__DIR__ . '/../');

$rootPath = str_replace('\\', '/', $rootPath);

require $rootPath . '/app/routes.php';
$app = new \GoNetwork\Core\App($rootPath);

$app->run();
