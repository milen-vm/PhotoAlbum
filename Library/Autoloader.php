<?php
namespace MyMVC\Library;

class Autoloader
{

    public static function init()
    {
        spl_autoload_register(function ($class)
        {
            $pathElements = explode('\\', $class);
            array_shift($pathElements);
            $path = ROOT_DIR . implode(DIRECTORY_SEPARATOR, $pathElements) . '.php';

            if (file_exists($path)) {
                require_once $path;
            }
        });
    }
}