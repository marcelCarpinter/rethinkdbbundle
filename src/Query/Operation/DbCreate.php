<?php
declare(strict_types = 1);

namespace MCarpinter\RethinkDb\Query\Operation;

use MCarpinter\RethinkDb\Query\AbstractQuery;
use MCarpinter\RethinkDb\RethinkInterface;
use MCarpinter\RethinkDb\Types\Term\TermType;

class DbCreate extends AbstractQuery
{
    /**
     * @var string
     */
    private $name;

    public function __construct(RethinkInterface $rethink, string $name)
    {
        parent::__construct($rethink);

        $this->rethink = $rethink;
        
        $this->name = $name;
    }

    public function toArray(): array
    {
        return [
            TermType::DB_CREATE,
            [
                [
                    TermType::DATUM,
                    $this->name,
                ],
            ],
        ];
    }
}
