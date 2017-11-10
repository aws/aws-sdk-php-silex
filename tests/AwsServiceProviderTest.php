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

namespace Aws\Silex;

use Silex\Application;
use PHPUnit\Framework\TestCase;

/**
 * AwsServiceProvider test cases
 */
class AwsServiceProviderTest extends TestCase
{
    public function testRegisterAwsServiceProvider()
    {
        // Setup the Silex app and AWS service provider
        $app = new Application();
        $provider = new AwsServiceProvider();
        $app->register($provider, array(
            'aws.config' => array(
                'version' => '2006-03-01',
                'region' => 'us-east-1',
                'credentials' => [
                    'key' => 'fake-aws-key',
                    'secret' => 'fake-aws-secret',
                ],
            )
        ));

        // Get an instance of a client (S3) to use for testing
        $s3 = $app['aws']->createS3();

        // Verify that the app and clients created by the SDK receive the provided credentials
        $this->assertEquals('2006-03-01', $app['aws.config']['version']);
        $this->assertEquals('us-east-1', $app['aws.config']['region']);
        $this->assertEquals('2006-03-01', $s3->getApi()->getApiVersion());
        $this->assertEquals('us-east-1', $s3->getRegion());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testNoConfigProvided()
    {
        // Setup the Silex app and AWS service provider
        $app = new Application();
        $provider = new AwsServiceProvider();
        $app->register($provider, array(
            'aws.config' => array(
                'credentials' => [
                    'key' => 'fake-aws-key',
                    'secret' => 'fake-aws-secret',
                ],
            )
        ));

        // Instantiate a client, which should trigger an exception for missing configs
        $s3 = $app['aws']->createS3();
    }
}
