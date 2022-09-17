<?php

namespace MCarpinter\Rethinkdb;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class RethinkDbBundle extends Bundle
{
    private $unicornsAreReal;

    private $minSunshine;

    public function __construct(bool $unicornsAreReal = true, $minSunshine = 3)
    {
        $this->unicornsAreReal = $unicornsAreReal;
        $this->minSunshine = $minSunshine;
    }

    /**
     * Returns several paragraphs of random ipsum text.
     *
     * @param int $count
     * @return string
     */
    public function getParagraphs(int $count = 3): string
    {

        return "Paragraph";
    }
}
