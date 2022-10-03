<?php
declare(strict_types = 1);

namespace MCarpinter\RethinkDb\Query\Operation;

use MCarpinter\RethinkDb\Query\AbstractQuery;
use MCarpinter\RethinkDb\Query\QueryInterface;
use MCarpinter\RethinkDb\RethinkInterface;
use MCarpinter\RethinkDb\Types\Term\TermType;

class IndexRename extends AbstractQuery
{
    /**
     * @var string
     */
    private $oldValue;

    /**
     * @var string
     */
    private $newValue;

    /**
     * @var QueryInterface
     */
    private $query;

    public function __construct(
        RethinkInterface $rethink,
        QueryInterface $query,
        string $oldValue,
        string $newValue
    ) {
        parent::__construct($rethink);

        $this->query = $query;
        $this->rethink = $rethink;

        $this->oldValue = $oldValue;
        $this->newValue = $newValue;
    }

    public function toArray(): array
    {
        return [
            TermType::INDEX_RENAME,
            [
                $this->query->toArray(),
                [
                    TermType::DATUM,
                    $this->oldValue,
                ],
                [
                    TermType::DATUM,
                    $this->newValue,
                ],
            ],
        ];
    }
}
