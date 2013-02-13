<?php
/**
 * Copyright 2012-2013 Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 * http://aws.amazon.com/apache2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

namespace Aws\Silex\Tests;

use Aws\Silex\AwsServiceProvider;
use Silex\Application;

/**
 * AwsServiceProvider test cases
 */
class AwsServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testRegisterAwsServiceProvider()
    {
        // Setup the Silex app and AWS service provider
        $app = new Application();
        $provider = new AwsServiceProvider();
        $app->register($provider, array(
            'aws.config' => array(
                'key'    => 'your-aws-access-key-id',
                'secret' => 'your-aws-secret-access-key',
            )
        ));
        $provider->boot($app);

        // Get an instance of a client (S3) to use for testing
        $s3 = $app['aws']->get('s3');

        // Verify that the app and clients created by the SDK receive the provided credentials
        $this->assertEquals('your-aws-access-key-id', $app['aws.config']['key']);
        $this->assertEquals('your-aws-secret-access-key', $app['aws.config']['secret']);
        $this->assertEquals('your-aws-access-key-id', $s3->getCredentials()->getAccessKeyId());
        $this->assertEquals('your-aws-secret-access-key', $s3->getCredentials()->getSecretKey());

        // Make sure the user agent contains "Silex"
        $command = $s3->getCommand('ListBuckets');
        $request = $command->prepare();
        $s3->dispatch('command.before_send', array('command' => $command));
        $this->assertRegExp('/.+Silex\/.+/', $request->getHeader('User-Agent', true));
    }

    /**
     * @expectedException \Aws\Common\Exception\InstanceProfileCredentialsException
     */
    public function testNoConfigProvided()
    {
        // Setup the Silex app and AWS service provider
        $app = new Application();
        $provider = new AwsServiceProvider();
        $app->register($provider);
        $provider->boot($app);

        // Instantiate a client and get the access key, which should trigger an exception trying to use IAM credentials
        $s3 = $app['aws']->get('s3');
        $s3->getCredentials()->getAccessKeyId();
    }
}
