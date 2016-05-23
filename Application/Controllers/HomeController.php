<?php
namespace MyMVC\Application\Controllers;

use MyMVC\Library\MVC\Controller;
use MyMVC\Library\MVC\View;
use MyMVC\Application\ViewModels\User;
use MyMVC\Library\Utility\Storage;
use MyMVC\Library\Config;

class HomeController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
//         $ip = '46.233.7.17'; //$_SERVER['REMOTE_ADDR'];
//         $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));

        return new View(new User(Storage::get('name'), Storage::get('lang'), 35));
    }

    public function lnag($lang)
    {
        if (in_array($lang, Config::get('languages'))) {
            Storage::set('lang', $lang);
        }

        $this->redirect();
    }
}