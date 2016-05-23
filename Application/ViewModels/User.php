<?php
namespace MyMVC\Application\ViewModels;

class User
{
    
    private $name;
    
    private $family;
    
    private $age;
    
    public function __construct($name, $family, $age)
    {
        $this->name = $name;
        $this->family = $family;
        $this->age = $age;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getFamily()
    {
        return $this->family;
    }
    
    public function getAge()
    {
        return $this->age;
    }
}