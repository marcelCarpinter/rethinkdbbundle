<?php

namespace MCarpinter\RethinkDb\Service;

use Exception;
use MCarpinter\RethinkDb\Connection\ConnectionException;
use MCarpinter\RethinkDb\Connection\ConnectionInterface;
use MCarpinter\RethinkDb\Connection\Registry;
use MCarpinter\RethinkDb\Connection\Options;
use MCarpinter\RethinkDb\Query\Builder;
use MCarpinter\RethinkDb\RethinkInterface;
use MCarpinter\RethinkDb\Query\Database;
use MCarpinter\RethinkDb\Query\Table;
use MCarpinter\RethinkDb\Query\Ordening;
use MCarpinter\RethinkDb\Query\Row;

class RethinkDb implements RethinkInterface
{
    /**
     * @var Builder
     */
    private $builder;
    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var Registry
     */
    public $registry;

    /**
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->builder = new Builder($this);
    }

    /**
     * @param string $name
     * @throws ConnectionException
     */
    public function setConnection(string $name){
        $this->connection = $this->registry->getConnection($name);
        try{
            $this->connection()->connect();
        }
        catch(ConnectionException $e){
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param string $connectionName
     * @param string $dbName
     * @throws ConnectionException
     */
    public function setConnectionOptions(string $connectionName, string $dbName){
        $options = new Options([
            'hostname' => 'rethinkdb', //make value to be on settings
            'port' => 28015, //amek value to be on settings
            'default_db' => $dbName,
            'dbname' => $dbName,
            'user' => 'admin', //make value to be on settings
            'password' => '', //make value to be on settings
            'timeout' => 5,
            'timeout_stream' => 10,
        ]);
        $this->registry = new Registry(
            [
                $connectionName => $options
            ]
        );
    }

    /**
     * @return Database
     */
    public function db(): Database
    {
        return $this->builder->database();
    }

    /**
     * Creates a new database. Returns true on success. False on failure
     * @param string $name
     * @return bool
     */
    public function dbCreate(string $name): bool
    {
        try{
            $this->builder->database()->dbCreate($name)->run();
            return true;
        }
        catch (ConnectionException $e){
            return false;
        }
    }

    /**
     * @param string $name
     * @return Database
     */
    public function dbDrop(string $name): Database
    {
        return $this->builder->database()->dbDrop($name);
    }

    /**
     * @return array|string
     */
    public function dbList(): array|string
    {
        return $this->builder->database()->dbList()->run()->getData();
    }

    /**
     * @return ConnectionInterface
     */
    public function connection(): ConnectionInterface
    {
        return $this->connection;
    }

    /**
     * @param string $name
     * @return Table
     */
    public function table(string $name): Table
    {
        return $this->builder->table($name);
    }

    /**
     * @param $key
     * @return Ordening
     */
    public function desc($key): Ordening
    {
        return $this->builder->ordening($key)->desc($key);
    }

    /**
     * @param $key
     * @return Ordening
     */
    public function asc($key): Ordening
    {
        return $this->builder->ordening($key)->asc($key);
    }

    /**
     * @param string|null $value
     * @return Row
     */
    public function row(?string $value = null): Row
    {
        return $this->builder->row($value);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function dbExists(string $name): bool
    {
        return in_array($name, $this->dbList());
    }

    /**
     * @param string $name
     * @return bool
     */
    public function connectionExists(string $name): string{
        return $this->registry->hasConnection($name);
    }
}