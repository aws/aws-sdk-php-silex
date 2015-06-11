# AWS Service Provider for Silex

[![Latest Stable Version](https://poser.pugx.org/aws/aws-sdk-php-silex/v/stable.png)](https://packagist.org/packages/aws/aws-sdk-php-silex)
[![Total Downloads](https://poser.pugx.org/aws/aws-sdk-php-silex/downloads.png)](https://packagist.org/packages/aws/aws-sdk-php-silex)

A simple Silex service provider for including the [AWS SDK for PHP](https://github.com/aws/aws-sdk-php).

## Installation

The AWS Service Provider can be installed via [Composer](http://getcomposer.org) by requiring the
`aws/aws-sdk-php-silex` package in your project's `composer.json`.

```json
{
    "require": {
        "aws/aws-sdk-php-silex": "~2.0"
    }
}
```

## Usage

Register the AWS Service Provider in your Silex application and provide your AWS SDK for PHP configuration to the app
in the `aws.config` key. `$app['aws.config']` should contain an array of configuration options or the path to a
configuration file. This value is passed directly into `new Aws\Sdk`.

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use Aws\Silex\AwsServiceProvider;
use Silex\Application;

$app = new Application();

$app->register(new AwsServiceProvider(), array(
    'aws.config' => array(
        'version' => 'latest',
        'region' => 'us-east-1',
    )
));
// Note: You can also specify a path to a config file
// (e.g., 'aws.config' => '/path/to/aws/config/file.php')

$app->match('/', function () use ($app) {
    // Get the Amazon S3 client
    $s3 = $app['aws']->createS3();

    // Create a list of the buckets in your account
    $output = "<ul>\n";
    foreach ($s3->getListBucketsIterator() as $bucket) {
        $output .= "<li>{$bucket['Name']}</li>\n";
    }
    $output .= "</ul>\n";

    return $output;
});

$app->run();
```

## Links

* [AWS SDK for PHP on Github](http://github.com/aws/aws-sdk-php)
* [AWS SDK for PHP website](http://aws.amazon.com/sdkforphp/)
* [AWS on Packagist](https://packagist.org/packages/aws)
* [License](http://aws.amazon.com/apache2.0/)
* [Silex website](http://silex.sensiolabs.org)
