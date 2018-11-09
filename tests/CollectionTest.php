<?php

use PHPUnit\Framework\TestCase;
use astroanu\S3DB\Database;
use astroanu\S3DB\Collection;

class CollectionTest extends TestCase
{

    use SetupTrait;

    public function testDelete()
    {
        $uuid = $this->database->collection('test')->put([
            'data' => [
                'interval' => 23
            ]
        ]);

        $result = $this->database->collection('test')->delete($uuid);

        $this->assertTrue($result);

        $result = $this->database->collection('test')->find($uuid);

        $this->assertTrue(is_null($result));
    }

    public function testPut()
    {
        $uuid = $this->database->collection('test')->put([
            'data' => [
                'interval' => 23
            ]
        ]);

        $this->assertTrue(is_string($uuid));
    }

    public function testFind()
    {
        $document = [
            'data' => [
                'interval' => 23
            ]
        ];

        $uuid = $this->database->collection('test')->put($document);

        $result = $this->database->collection('test')->find($uuid);

        $this->assertJsonStringEqualsJsonString(
            json_encode($document),
            json_encode($result)
        );
    }
}