# AWS Service Provider for Silex

[![@awsforphp on Twitter](http://img.shields.io/badge/twitter-%40awsforphp-blue.svg?style=flat)](https://twitter.com/awsforphp)
[![Build Status](https://travis-ci.org/aws/aws-sdk-php-silex.svg)](https://travis-ci.org/aws/aws-sdk-php-silex)
[![Latest Stable Version](https://poser.pugx.org/aws/aws-sdk-php-silex/v/stable.png)](https://packagist.org/packages/aws/aws-sdk-php-silex)
[![Total Downloads](https://poser.pugx.org/aws/aws-sdk-php-silex/downloads.png)](https://packagist.org/packages/aws/aws-sdk-php-silex)

A simple Silex 2 / Pimple 3 service provider for including the [AWS SDK for PHP](https://github.com/aws/aws-sdk-php).

note:
    If you are using the 1.x Silex version, Use [version 2.x]
    (https://github.com/aws/aws-sdk-php-silex/tree/2.0) of this provider.

Jump To:
* [Getting Started](_#Getting-Started_)
* [Getting Help](_#Getting-Help_)
* [Contributing](_#Contributing_)
* [More Resources](_#Resources_) 

## Getting Started 

### Installation

The AWS Service Provider can be installed via [Composer](http://getcomposer.org) by requiring the
`aws/aws-sdk-php-silex` package in your project's `composer.json`.

```json
{
    "require": {
        "aws/aws-sdk-php-silex": "~3.0"
    }
}
```

### Usage

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

## Getting Help

Please use these community resources for getting help. We use the GitHub issues for tracking bugs and feature requests and have limited bandwidth to address them.

* Ask a question on [StackOverflow](https://stackoverflow.com/) and tag it with [`aws-php-sdk`](http://stackoverflow.com/questions/tagged/aws-php-sdk)
* Come join the AWS SDK for PHP [gitter](https://gitter.im/aws/aws-sdk-php)
* Open a support ticket with [AWS Support](https://console.aws.amazon.com/support/home/)
* If it turns out that you may have found a bug, please [open an issue](https://github.com/aws/aws-sdk-php-silex/issues/new/choose)

This SDK implements AWS service APIs. For general issues regarding the AWS services and their limitations, you may also take a look at the [Amazon Web Services Discussion Forums](https://forums.aws.amazon.com/).

### Opening Issues

If you encounter a bug with `aws-sdk-php-silex` we would like to hear about it. Search the existing issues and try to make sure your problem doesn’t already exist before opening a new issue. It’s helpful if you include the version of `aws-sdk-php-silex`, PHP version and OS you’re using. Please include a stack trace and reduced repro case when appropriate, too.

The GitHub issues are intended for bug reports and feature requests. For help and questions with using `aws-sdk-php` please make use of the resources listed in the Getting Help section. There are limited resources available for handling issues and by keeping the list of open issues lean we can respond in a timely manner.

## Contributing

We work hard to provide a high-quality and useful SDK for our AWS services, and we greatly value feedback and contributions from our community. Please review our [contributing guidelines](./CONTRIBUTING.md) before submitting any issues or pull requests to ensure we have all the necessary information to effectively respond to your bug report or contribution.

## Resources

* [AWS SDK for PHP on Github](http://github.com/aws/aws-sdk-php)
* [AWS SDK for PHP website](http://aws.amazon.com/sdkforphp/)
* [AWS on Packagist](https://packagist.org/packages/aws)
* [License](http://aws.amazon.com/apache2.0/)
* [Silex website](http://silex.sensiolabs.org)
