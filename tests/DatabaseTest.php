<?php

use PHPUnit\Framework\TestCase;
use astroanu\S3DB\Database;
use astroanu\S3DB\Collection;

class DatabaseTest extends TestCase
{

    use SetupTrait;

    public function testCollection()
    {
        $this->assertInstanceOf(
            Collection::class,
            $this->database->collection('test')
        );
    }

    public function testListCollections()
    {
        $collections = $this->database->listCollections();

        $this->assertContains(
            'test',
            $collections
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            Database::class,
            $this->database
        );
    }
}