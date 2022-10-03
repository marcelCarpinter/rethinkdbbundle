<?php
declare(strict_types = 1);

namespace MCarpinter\RethinkDb\Query;

interface OptionsInterface extends \JsonSerializable
{
    public function setDb(string $name): OptionsInterface;
}
