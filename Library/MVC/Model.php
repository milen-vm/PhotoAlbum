<?php
namespace MyMVC\Library\MVC;

use MyMVC\Library\Core\Database;
use MyMVC\Library\Config;

abstract class Model
{

    /**
     *
     * @var \MyMVC\Library\Core\Database
     */
    protected $db;

    protected $table;

    public function __construct($args = [], \MyMVC\Library\Core\Database $db = null)
    {
        $this->setTable($args);
        $this->setDb($db);
    }

    private function setDb($db)
    {
        if ($db == null) {
            $this->db = Database::getInstance(Config::get('dbInstance'));
        } else {
            $this->db = $db;
        }
    }

    private function setTable($args)
    {
        if (isset($args['table'])) {
            $this->table = $args['table'];
        } else {
            throw new \Exception('Table name is missing.');
        }
    }

    /**
     *
     * @param array $pairs
     * @throws \Exception
     * @return string
     */
    protected function insert($pairs)
    {
        $columns = array_keys($pairs);
        $values = array_values($pairs);
        $placeholders = str_repeat('?,', count($values));
        $placeholders = rtrim($placeholders, ',');

        $stmt = 'INSERT INTO ' . $this->table . ' (' .
            implode(',', $columns) . ') ' . 'VALUES(' . $placeholders . ')';

        $result = $this->db->prepare($stmt);
        $result->execute($values);

        if ($result->rowCount() > 0) {
            return $this->db->lastId();
        }

        throw new \Exception('Database error.');
    }

    /**
     *
     * @param array $args
     * @param array $params
     * @return array
     */
    protected function find($args = [], $params = [], $fetchStyle = \PDO::FETCH_ASSOC)
    {
        $result = $this->prepareFind($args, $params);
        $arr = $result->fetch($fetchStyle);

        return  $arr !== false ? $arr : [];
    }

    /**
     *
     * @param array $args
     * @param array $params
     * @return array
     */
    protected function findAll($args = [], $params = [], $fetchStyle = \PDO::FETCH_ASSOC)
    {
        $result = $this->prepareFind($args, $params);

        return $result->fetchAll($fetchStyle);
    }

    /**
     *
     * @param array $args
     * @param array $params
     * @return string
     */
    protected function findColumn($args, $params)
    {
        $result = $this->prepareFind($args, $params);

        return $result->fetchColumn();
    }

    private function prepareFind($args, $params)
    {
        $stmtArgs = array_merge([
            'select' => '*',
            'from' => $this->table,
            'join' => [],
            'where' => '',
            'orderby' => '',
            'limit' => 0
        ], $args);

        $stmt = $this->buildStmt($stmtArgs);
        $result = $this->db->prepare($stmt);
        $result->execute($params);

        return $result;
    }

    private function buildStmt($args)
    {
        $stmt = 'SELECT ' . $args['select'] .
            ' FROM ' . $args['from'];

        if (count($args['join']) > 0) {
            foreach ($args['join'] as $join) {
                $stmt .= ' LEFT JOIN ' . $join;
            }
        }

        if (!empty($args['where'])) {
            $stmt .= ' WHERE ' . $args['where'];
        }

        // ORDER BY column_name ASC|DESC, column_name ASC|DESC ...
        if (!empty($args['orderby'])) {
            $stmt .= ' ORDER BY ' . $args['orderby'];
        }

        if (!empty($args['limit'])) {
            $stmt .= ' LIMIT ' . $args['limit'];
        }

        return $stmt;
    }
}