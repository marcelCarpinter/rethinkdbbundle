<?php
declare(strict_types = 1);

namespace MCarpinter\RethinkDb\Query;

use MCarpinter\RethinkDb\Query\Operation\DbCreate;
use MCarpinter\RethinkDb\Query\Operation\DbDrop;
use MCarpinter\RethinkDb\Query\Operation\DbList;
use MCarpinter\RethinkDb\Query\Operation\TableCreate;
use MCarpinter\RethinkDb\Query\Operation\TableDrop;
use MCarpinter\RethinkDb\Query\Operation\TableList;
use MCarpinter\RethinkDb\RethinkInterface;

class Database extends AbstractQuery
{
    /**
     * @var QueryInterface
     */
    private $query;

    public function __construct(RethinkInterface $rethink)
    {
        parent::__construct($rethink);

        $this->dbList();
    }

    public function dbCreate(string $name): Database
    {
        $this->query = new DbCreate($this->rethink, $name);

        return $this;
    }

    public function dbDrop(string $name): Database
    {
        $this->query = new DbDrop($this->rethink, $name);

        return $this;
    }

    public function dbList(): Database
    {
        $this->query = new DbList($this->rethink);

        return $this;
    }

    public function tableList(): Database
    {
        $this->query = new TableList($this->rethink);

        return $this;
    }

    public function tableCreate(string $name): Database
    {
        $this->query = new TableCreate($this->rethink, $name);

        return $this;
    }

    public function tableDrop(string $name): Database
    {
        $this->query = new TableDrop($this->rethink, $name);

        return $this;
    }

    public function toArray(): array
    {
        return $this->query->toArray();
    }
}
