<?php
namespace MyMVC\Library\Core\Drivers;

abstract class BaseDriver
{

    protected $username;

    protected $password;

    protected $dbName;

    protected $host;

    public function __construct($username, $password, $dbName, $host = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->dbName = $dbName;
        $this->host = $host;
    }

    public abstract function getDSN();
}