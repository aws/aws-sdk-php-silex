<?php
/**
 * Copyright 2013 Amazon.com, Inc. or its affiliates. All Rights Reserved.
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

use Aws\Common\Aws;
use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * AWS SDK for PHP service provider for Silex applications
 */
class AwsServiceProvider implements ServiceProviderInterface
{
    /**
     * @inheritdoc
     */
    public function register(Application $app)
    {
        $app['aws'] = $app->share(function (Application $app) {
            return Aws::factory($app['aws.config']);
        });
    }

    /**
     * @inheritdoc
     */
    public function boot(Application $app)
    {
    }
}
