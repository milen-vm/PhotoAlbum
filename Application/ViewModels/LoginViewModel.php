<?php
namespace MyMVC\Application\ViewModels;

use MyMVC\Library\MVC\ViewModel;

class LoginViewModel extends ViewModel
{

    private $email = '';

    private $password = '';

    public function __construct($csrfToken)
    {
        $this->csrfToken = $csrfToken;
    }

    public function getEmail()
    {
        return $this->email;
    }

    private function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    private function setPassword($password)
    {
        $this->password = $password;
    }
}