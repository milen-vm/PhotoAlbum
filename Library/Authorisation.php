<?php
namespace MyMVC\Library;

use MyMVC\Library\Utility\Session;
use MyMVC\Application\Models\UserModel;

class Authorisation
{

    const ANOTATION_PATTERN = '/@([A-Z]+) (.*)$/mi';

    /**
     *
     * @var String[] annotations that developer can use in method documentation
     */
    private $annotations = ['auth', 'guest'];

    private $annotation;

    /**
     *
     * @var String redirection path if user status not match method authorisation
     */
    private $path;

    public function __construct($class, $method)
    {
        $this->setParams($class, $method);
    }

    private function setParams($class, $method)
    {
        $reflClass = new \ReflectionClass($class);
        $reflMethod = $reflClass->getMethod($method);
        $doc = $reflMethod->getDocComment();

        $arr = [];
        preg_match_all(self::ANOTATION_PATTERN, $doc, $arr);

        for ($i = 0; $i < count($arr[1]); $i++) {
            $annot = strtolower($arr[1][$i]);

            if (in_array($annot, $this->annotations)) {
                $this->annotation = $annot;
                $this->path = $arr[2][$i];

                break;
            }
        }
    }

    public function getPath()
    {
        return $this->path;
    }

    /**
     *
     * @return boolean
     */
    public function process()
    {
        if ($this->annotation !== null) {
            $method = 'is' . ucfirst($this->annotation);
            if (method_exists($this, $method)) {
                return $this->{$method}();
            }
        }

        return true;
    }

    private function isAuth()
    {
        return Session::isSetKey('id');
    }

    private function isGuest()
    {
        return !Session::isSetKey('id');
    }

    private function isAdmin()
    {
        if (Session::isSetKey('role')) {
            return Session::get('role') == UserModel::ADMINISTRATION_ROLE;
        }

        return false;
    }
}