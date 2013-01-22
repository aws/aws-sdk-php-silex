# AWS Service Provider for Silex

A simple Silex service provider for including the [AWS SDK for PHP](https://github.com/aws/aws-sdk-php).

## Installation

The AWS Service Provider can be installed via [Composer](http://getcomposer.org) by requiring the following package:

```json
{
    "require": {
        "aws/aws-sdk-php-silex": "1.*"
    }
}
```

## Usage

Register the AWS Service Provider in your Silex application and provide your AWS SDK for PHP configuration to the app
in the `aws.config` key. `$app['aws.config']` should be contain an array of configuration options or the path to a
configuration file. This value is passed directly into `Aws\Common\Aws::factory()`.

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use Aws\Common\Enum\Region;
use Aws\Silex\AwsServiceProvider;
use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

$app = new Application();

$app->register(new AwsServiceProvider(), array(
    'aws.config' => array(
        'key'    => 'your-aws-access-key-id',
        'secret' => 'your-aws-secret-access-key',
        'region' => Region::US_EAST_1
    )
));

$app->match('/', function () use ($app) {
    $s3 = $app['aws']->get('s3');
    $buckets = $s3->getIterator('ListBuckets');

    $output = "<ul>\n";
    foreach ($buckets as $bucket) {
        $output .= "<li>{$bucket['Name']}</li>\n";
    }
    $output .= "</ul>\n";

    return new Response($output);
});

$app->run();
```

## Links

* [AWS SDK for PHP on Github](http://github.com/aws/aws-sdk-php)
* [AWS SDK for PHP website](http://aws.amazon.com/sdkforphp2)
* [License](http://aws.amazon.com/apache2.0/)
* [Silex website](http://silex.sensiolabs.org)
