<?php
/**
 * init.php
 */
use Aws\S3\S3Client;

// Requiring autoloader
require_once "../vendor/autoload.php";

// Assigning whole file to a var
$config = require_once "config.php";


// passing elements from config.php
$s3 = new S3Client([
    "version" => $config["s3"]["version"],
    "region" => $config["s3"]["region"],
    "credentials" => [
        "key" => $config["s3"]["key"],
        "secret" => $config["s3"]["secret"],
    ]
]);