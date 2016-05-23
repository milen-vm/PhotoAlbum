<?php
namespace MyMVC\Library\MVC;

use MyMVC\Library\App;
use MyMVC\Library\Utility\Hellper;

abstract class Controller
{

    protected $method;

    public function __construct()
    {
    	$this->method = App::getRouter()->getRequestMethod();
    }

    protected function isMethodPost()
    {
        return $this->method == 'POST';
    }

    public function index()
    {}
}