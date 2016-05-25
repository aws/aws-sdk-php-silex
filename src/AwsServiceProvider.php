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

use Aws\Sdk;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;

/**
 * AWS SDK for PHP service provider for Silex applications
 */
class AwsServiceProvider implements ServiceProviderInterface
{
    const VERSION = '3.0.0';

    public function register(Container $container)
    {
        $container['aws'] = function (Application $container) {
            $config = isset($container['aws.config']) ? $container['aws.config'] : [];

            return new Sdk($config + ['ua_append' => [
                'Silex/' . Application::VERSION,
                'SXMOD/' . self::VERSION,
            ]]);
        };
    }
}
