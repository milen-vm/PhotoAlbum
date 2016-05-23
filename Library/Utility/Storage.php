<?php
namespace MyMVC\Library\Utility;

class Storage
{

    const EXPIRATION_PERIOD = 2592000;    // 30 days

    public static function set(
        $name,
        $value,
        $expire = null,
        $path = '/',
        $domain = '',
        $secure = false,
        $httpOnly = true
    ) {
        $expire = $expire == null ? time() + self::EXPIRATION_PERIOD : $expire;

        setcookie($name, $value, $expire, $path, $domain, $secure, $httpOnly);
        $_COOKIE[$name] = $value;
    }

    public static function get($name)
    {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
    }

    /**
     *
     * @todo Refactor cookie creation
     */
    private function build_cookie($var_array) {
        if (is_array($var_array)) {
            foreach ($var_array as $index => $data) {
                $out.= ($data!="") ? $index."=".$data."|" : "";
            }
        }
        return rtrim($out,"|");
    }

    private function break_cookie ($cookie_string) {
        $array=explode("|",$cookie_string);
        foreach ($array as $i=>$stuff) {
            $stuff=explode("=",$stuff);
            $array[$stuff[0]]=$stuff[1];
            unset($array[$i]);
        }
        return $array;
    }
}