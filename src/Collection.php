<?php

namespace astroanu\S3DB;

use astroanu\S3DB\Exceptions\S3DBException;
use Aws\S3\Exception\S3Exception;
use Ramsey\Uuid\Uuid;

class Collection{

    protected $database;
    protected $name;

    public function delete($id)
    {
        try {

            $uuid = Uuid::uuid4();
            
            $objects = $this->database->getClient()->deleteObject([
                'Key' => $this->getKeyName($id),
                'Bucket' => $this->database->getBucket() 
            ]);

            return true;

        } catch (S3Exception $e) {

            throw new S3DBException($e);
        }
    }

    public function put($document)
    {
        try {

            $uuid = Uuid::uuid4();
            
            $objects = $this->database->getClient()->putObject([
                'Body' => json_encode($document),
                'Key' => $this->getKeyName($uuid),
                'Bucket' => $this->database->getBucket() 
            ]);

            return (string) $uuid;

        } catch (S3Exception $e) {

            throw new S3DBException($e);
        }
    }

    public function find($id)
    {
        try {
            
            $result = $this->database->getClient()->getObject([
                'Key' => $this->getKeyName($id),
                'Bucket' => $this->database->getBucket() 
            ]);

            return json_decode((string)$result['Body']);

        } catch (S3Exception $e) {

            if($e->getStatusCode() == 404){

                return null;
            }

            throw new S3DBException($e);
        }
    }

    private function getKeyName($id)
    {
        return 'collection_' . $this->name . '/' . $id;
    }

    public function __construct(Database $database, $name)
    {

        $this->database = $database;
        $this->name = $name;
    }
}