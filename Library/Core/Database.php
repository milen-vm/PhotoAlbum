<?php
namespace MyMVC\Library\Core;

use MyMVC\Library\Core\Drivers\DriverFactory;

class Database
{

    private static $inst = [];

    /**
     *@var \PDO
     */
    private $db;

    private function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     *
     * @param string $instanceName
     * @return \MyMVC\Library\Core\Database
     * @throws \Exception
     */
    public static function getInstance($instanceName = 'default')
    {
        if (!isset(self::$inst[$instanceName])) {
        	throw new \Exception("Instance with name {$instanceName}, was not set.");
        }

        return self::$inst[$instanceName];
    }

    public static function setInstance(
        $instanceName,
        $dirverName,
        $username,
        $password,
        $dbName,
        $host = null
    ) {
        $driver = DriverFactory::create($dirverName, $username, $password, $dbName, $host);
        $pdo = new \PDO(
            $driver->getDSN(),
            $username,
            $password,
            [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
        );

        self::$inst[$instanceName] = new self($pdo);
    }

    /**
     *
     * @param string $statement
     * @param array $driverOptions
     * @return \MyMVC\Library\Core\Statement
     */
    public function prepare($statement, array $driverOptions = [])
    {
        $pdoStatement = $this->db->prepare($statement, $driverOptions);

        return new Statement($pdoStatement);
    }

    public function query($query)
    {
        $this->db->query($query);
    }

    public function lastId($name = null)
    {
        return $this->db->lastInsertId($name);
    }
}

class Statement
{

    /**
     *
     * @var \PDOStatement
     */
    private $stmt;

    /**
     *
     * @param \PDOStatement $pdoStatement
     */
    public function __construct(\PDOStatement $pdoStatement)
    {
        $this->stmt = $pdoStatement;
    }

    /**
     *
     * @param int $fetchStyle
     * @return array
     */
    public function fetch($fetchStyle = \PDO::FETCH_ASSOC)
    {
        return $this->stmt->fetch($fetchStyle);
    }

    /**
     *
     * @param int $fetchStyle
     * @return array
     */
    public function fetchAll($fetchStyle = \PDO::FETCH_ASSOC)
    {
        return $this->stmt->fetchAll($fetchStyle);
    }

    public function bindParam(
    	$parameter,
        &$variable,
        $dataType = \PDO::PARAM_STR,
        $length = null,
        $dirverOptions = null
    ) {
        return $this->stmt->bindParam($parameter, $variable,
            $dataType, $length, $dirverOptions);
    }

    /**
     *
     * @param array|null $inputParameters
     * @return boolean
     */
    public function execute(array $inputParameters = null)
    {
        $this->stmt->execute($inputParameters);
    }

    /**
     *
     * @return number
     */
    public function rowCount()
    {
        return (int)$this->stmt->rowCount();
    }

    /**
     *
     * @return array:
     */
    public function error()
    {
        return $this->stmt->errorInfo();
    }
}