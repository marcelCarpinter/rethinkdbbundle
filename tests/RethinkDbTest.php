<?php

namespace MCarpinter\RethinkDb\Tests;

use MCarpinter\RethinkDb\RethinkDbBundle;
use \PHPUnit\Framework\TestCase;
use Mockery;

class RethinkDbTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    protected function setUp(): void
    {
        Mockery::getConfiguration()->allowMockingNonExistentMethods(false);

        parent::setUp();
    }
}