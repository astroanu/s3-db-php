<?php

use astroanu\S3DB\Database;
use astroanu\S3DB\Collection;

trait SetupTrait{

    protected $database;
    
    protected function setUp()
    {

        $credentials = new Aws\Credentials\Credentials('xxx', 
        'xxxx');

        $client = new Aws\S3\S3Client([
            'version' => 'latest',
            'region' => 'us-east-1',
            'credentials' => $credentials
        ]);

        $bucket = 'kin-buck';

        $this->database = new Database($client, $bucket);
    }
}