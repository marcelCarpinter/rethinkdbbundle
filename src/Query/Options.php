<?php
declare(strict_types = 1);

namespace MCarpinter\RethinkDb\Query;

use MCarpinter\RethinkDb\Types\Term\TermType;

class Options implements OptionsInterface
{
    /**
     * @var array
     */
    private $db;

    public function setDb(string $name): OptionsInterface
    {
        $this->db = [
            TermType::DB,
            [$name],
        ];

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        if (empty($this->db)) {
            return [];
        }

        return [
            'db' => $this->db
        ];
    }
}
