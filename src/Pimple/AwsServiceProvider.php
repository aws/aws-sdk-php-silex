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

namespace Aws\Pimple;

use Aws\Sdk;
use Guzzle\Common\Event;
use Guzzle\Service\Client;

/**
 * AWS SDK for PHP service provider for Pimple based applications
 */
class AwsServiceProvider
{
    const VERSION = '2.1.0';

    public function register(\Pimple $app, $type = 'Pimple', $version = '0.0.0')
    {
        $app['aws'] = $app->share(function (\Pimple $app) use ($type, $version) {
            $config = isset($app['aws.config']) ? $app['aws.config'] : [];
            return new Sdk($config + ['ua_append' => [
                $type . '/' . $version,
                'SXMOD/' . self::VERSION,
            ]]);
        });
    }
}
