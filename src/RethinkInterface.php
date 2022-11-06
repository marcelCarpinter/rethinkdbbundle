<?php
declare(strict_types=1);

namespace MCarpinter\RethinkDb;

use MCarpinter\RethinkDb\Connection\ConnectionInterface;
use MCarpinter\RethinkDb\Query\Database;
use MCarpinter\RethinkDb\Query\Ordening;
use MCarpinter\RethinkDb\Query\Row;
use MCarpinter\RethinkDb\Query\Table;

interface RethinkInterface
{
    public function connection(): ConnectionInterface;

    public function table(string $name): Table;

    public function db(): Database;

    public function dbCreate(string $name): bool;

    public function dbDrop(string $name): Database;

    public function dbList(): array|string;

    public function desc($key): Ordening;

    public function asc($key): Ordening;

    public function row(?string $value = null): Row;

    public function dbExists(string $name): bool;

    public function connectionExists(string $name): string;

    public function setConnection(string $name);

    public function setConnectionOptions(string $connectionName, string $dbName);
}
