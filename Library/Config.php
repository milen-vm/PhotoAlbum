<?php
namespace MyMVC\Library;

class Config
{
    
    private static $setings = [];
    
    public static function get($key)
    {
        if (isset(self::$setings[$key])) {
        	return self::$setings[$key];
        }
        
        throw new \Exception("No key {$key} in setings array.");
    }
    
    public static function set($key, $value)
    {
        self::$setings[$key] = $value;
    }
}