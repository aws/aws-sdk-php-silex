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

use Aws\Common\Aws;
use Aws\Common\Client\UserAgentListener;
use Guzzle\Common\Event;
use Guzzle\Service\Client;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;

/**
 * AWS SDK for PHP service provider for Silex applications
 */
class AwsServiceProvider implements ServiceProviderInterface
{
    const VERSION = '2.0.0';

    public function register(Container $container)
    {
        $container['aws'] = function (Container $container) {
            // Instantiate the AWS service builder
            $config = isset($container['aws.config']) ? $container['aws.config'] : array();
            $aws = Aws::factory($config);

            // Attach an event listener that will append the Silex version number in the user agent string
            $aws->getEventDispatcher()->addListener('service_builder.create_client', function (Event $event) {
                $clientConfig = $event['client']->getConfig();
                $commandParams = $clientConfig->get(Client::COMMAND_PARAMS) ?: array();
                $userAgentData = 'Silex/' . Application::VERSION . ' SXMOD/' . AwsServiceProvider::VERSION;
                $clientConfig->set(Client::COMMAND_PARAMS, array_merge_recursive($commandParams, array(
                    UserAgentListener::OPTION => $userAgentData
                )));
            });

            return $aws;
        };
    }
}
