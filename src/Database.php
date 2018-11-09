<?php

namespace astroanu\S3DB;

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use astroanu\S3DB\Exceptions\S3DBException;

class Database{

    protected $client;
    protected $bucket;

    public function collection($name)
    {
        return new Collection($this, $name);
    }

    public function listCollections()
    {
        try {
            
            $objects = $this->client->listObjects([
                'Prefix' => 'collection_',
                'Bucket' => $this->bucket 
            ]);

            if(!isset($objects['Contents'])){

                return [];
            }

            return array_map(function($collection){

                return substr($collection['Key'], 11, -1);

            }, $objects['Contents']);

        } catch (S3Exception $e) {

            throw new S3DBException($e);
        }
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getBucket()
    {
        return $this->bucket;
    }

    public function __construct(S3Client $client, $bucket)
    {

        $this->client = $client;
        $this->bucket = $bucket;
    }
}