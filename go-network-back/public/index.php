<?php
//session_start();

// Antes que nada, requerimos el autoload.
require __DIR__ . '/../autoload.php';

//require_once __DIR__ . '/../app/Helpers/routes.php';

$rootPath = realpath(__DIR__ . '/../');
$rootPath = str_replace('\\', '/', $rootPath);
require $rootPath . '/app/routes.php';
$app = new \GoNetwork\Core\App($rootPath);

$app->run();
