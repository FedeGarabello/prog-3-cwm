<?php
//session_start();

// Antes que nada, requerimos el autoload.
require __DIR__ . '/../autoload.php';

//require_once __DIR__ . '/../app/Helpers/routes.php';

// Guardamos la ruta absoluta de base del proyecto.
$rootPath = realpath(__DIR__ . '/../');

// Normalizamos las \ a /
$rootPath = str_replace('\\', '/', $rootPath);

// Requerimos las rutas de la aplicación.
require $rootPath . '/app/routes.php';

// Instanciamos nuestra App.
$app = new \GoNetwork\Core\App($rootPath);

// Arrancamos la App.
$app->run();
