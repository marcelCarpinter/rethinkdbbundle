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


    public $registry;

    /**
     *
     * @throws Exception
     */
    public function __construct()
    {
        $options = new Options([
            'hostname' => 'rethinkdb',
            'port' => 28015,
            'default_db' => 'test',
            'user' => 'admin',
            'password' => '',
            'timeout' => 5,
            'timeout_stream' => 10,
            'dbname' => 'test'
        ]);
        $this->registry = new Registry(
            $connections = [
                'default_connection' => $options
            ]
        );
        try {
            $this->connection = $this->registry->getConnection('default_connection');
            try{
                $this->connection()->connect();
            }
            catch(ConnectionException $e){
                throw new Exception($e->getMessage(), $e->getCode());
            }
        }
        catch (ConnectionException $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }

        $this->builder = new Builder($this);
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

    public function dbExists(string $name): bool
    {
        return in_array($name, $this->dbList());
    }
}