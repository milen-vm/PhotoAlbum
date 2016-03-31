<?php
namespace MyMVC\Library;

use MyMVC\Library\Utility\Session;

class Authorisation
{

    /**
     *
     * @var String[] annotations that developer can use in method documentation
     */
    private $annotations = ['@loggedin', ];

    private $methodAnnotations = [];

    public function __construct($class, $method)
    {

        $reflClass = new \ReflectionClass($class);
        $reflMethod = $reflClass->getMethod($method);
        $methodDoc = $reflMethod->getDocComment();
        $this->setMethoAnnotations($methodDoc);
    }

    private function setMethoAnnotations($doc)
    {
        $arr = [];
        preg_match_all('/(@.*) (.*)$/im', $doc, $arr);

        for ($i = 0; $i < count($arr[1]); $i++) {
            $annotation = $arr[1][$i];

            if (in_array($annotation, $this->annotations)) {
                $this->methodAnnotations[$annotation] = $arr[2][$i];
            }
        }
    }

    public function runAnnotation()
    {
        foreach ($this->methodAnnotations as $annot => $val) {
            switch ($annot) {
            	case '@loggedin':
            	   $this->performLoggedin($val);
            	break;

            	default:
            		throw new \Exception('Server error.', 500);
            	break;
            }
        }
    }

    private function performLoggedin($path)
    {
        if (Session::isSetKey('id')) {
            $this->redirect($path);
        }
    }

    private function redirect($path)
    {
        $path = str_replace('\\', '/', $path);
        $path = trim($path, '/');

        $components = explode('/', $path);
        $route = array_shift($components);
        $controller = array_shift($components);
        $action = array_shift($components);

        App::redirect($route, $controller, $action, $components);
    }
}