<?php
namespace MyMVC\Application\ViewModels;

use MyMVC\Library\MVC\ViewModel;
use MyMVC\Library\Utility\Validation;

class FormAlbumViewModel extends ViewModel
{

    private $name = '';

    private $description = '';

    private $isPrivate = 1;

    public function __construct($csrfToken)
    {
        $this->csrfToken = $csrfToken;
        $this->validation = new Validation();
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    private function setName($name)
    {
        $this->name = $name;
    }

    private function setDescription($description)
    {
        $this->description = $description;
    }

    private function setIsPrivate($isPrivate)
    {
        if ($isPrivate == '') {
            $this->isPrivate = 0;
        }
    }
}