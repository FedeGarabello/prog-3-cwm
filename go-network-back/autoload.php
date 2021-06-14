<?php

session_start();

spl_autoload_register(function($className) {
    $className = str_replace("\\", DIRECTORY_SEPARATOR, $className);

    $filepath = __DIR__ . "/classes/" . $className . ".php";

    if(file_exists($filepath)) {
        require $filepath;
    }
});
