<?php
declare(strict_types = 1);

namespace MCarpinter\RethinkDb\Query;

use MCarpinter\RethinkDb\Query\Aggregation\AggregationTrait;
use MCarpinter\RethinkDb\Query\Operation\Between;
use MCarpinter\RethinkDb\Query\Manipulation\HasFields;
use MCarpinter\RethinkDb\Query\Manipulation\ManipulationTrait;
use MCarpinter\RethinkDb\Query\Operation\Changes;
use MCarpinter\RethinkDb\Query\Operation\Get;
use MCarpinter\RethinkDb\Query\Operation\IndexCreate;
use MCarpinter\RethinkDb\Query\Operation\IndexDrop;
use MCarpinter\RethinkDb\Query\Operation\IndexList;
use MCarpinter\RethinkDb\Query\Operation\IndexRename;
use MCarpinter\RethinkDb\Query\Operation\OperationTrait;
use MCarpinter\RethinkDb\Query\Operation\Sync;
use MCarpinter\RethinkDb\Query\Transformation\TransformationTrait;
use MCarpinter\RethinkDb\RethinkInterface;
use MCarpinter\RethinkDb\Types\Term\TermType;

class Table extends AbstractQuery
{
    use AggregationTrait;
    use OperationTrait;
    use TransformationTrait;

    /**
     * @var array
     */
    private $query;

    public function __construct(string $name, RethinkInterface $rethink)
    {
        parent::__construct($rethink);

        $this->rethink = $rethink;


        $this->query = [
            TermType::TABLE,
            [
                $name,
            ],
        ];
    }

    public function changes(array $options = null): Changes
    {
        return new Changes($this->rethink, $this, $options);
    }

    public function get($key): Get
    {
        return new Get($this->rethink, $this, $key);
    }

    public function indexCreate(string $name): AbstractQuery
    {
        return new IndexCreate($this->rethink, $this, $name);
    }

    public function indexDrop(string $name): AbstractQuery
    {
        return new IndexDrop($this->rethink, $this, $name);
    }

    public function indexList(): AbstractQuery
    {
        return new IndexList($this->rethink, $this);
    }

    public function indexRename(string $oldValue, string $newValue): AbstractQuery
    {
        return new IndexRename($this->rethink, $this, $oldValue, $newValue);
    }

    public function between($min, $max, array $options = null): Between
    {
        return new Between($this->rethink, $this, $min, $max, $options);
    }
  
    public function hasFields(...$keys)
    {
        return new HasFields($this->rethink, $this, $keys);
    }

    public function sync()
    {
        return new Sync($this->rethink, $this);
    }

    public function toArray(): array
    {
        return $this->query;
    }
}
