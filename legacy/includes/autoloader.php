<?php

/**
 * The autoloader must ONLY be configured if we are NOT inside Laravel
 */
if (!defined('LARAVEL_START')) {
    $dirName = dirname(__FILE__);

    spl_autoload_register(function ($class) use ($dirName) {
        if (strpos($class, 'Ds3\\Libraries\\Legacy\\') !== 0) {
            return;
        }

        $className = str_replace('Ds3\\Libraries\\Legacy\\', '', $class);
        $classFile = "$dirName/Ds3_Libraries_Legacy/$className.php";

        if (!file_exists($classFile)) {
            return;
        }

        require_once $classFile;
    });
}