# s3-db-php

A document database implementation on AWS S3

```php 

    $credentials = new Aws\Credentials\Credentials('key_id', 'access_key');

    $client = new Aws\S3\S3Client([
        'version' => 'latest',
        'region' => 'us-east-1',
        'credentials' => $credentials
    ]);

    $bucket = 'my-database';

    $database = new Database($client, $bucket);
    
    // Get a list of available collections
    $database->listCollections();
    
    // Put a document
    $uuid = $database->collection('my-collection')->put([
      "text": [
        "data": [
          "more-data": "value"
        ],
        "size": 36,
        "name": "text1",
        "alignment": "center"
      ]
    ]);
    
    // Find by id
    $document = $database->collection('my-collection')->find($uuid);
    
    // Delete by id
    $result = $database->collection('my-collection')->delete($uuid);
  
