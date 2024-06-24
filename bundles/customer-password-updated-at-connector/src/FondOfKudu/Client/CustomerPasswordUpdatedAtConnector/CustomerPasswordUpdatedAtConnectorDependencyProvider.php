<?php

namespace FondOfKudu\Client\CustomerPasswordUpdatedAtConnector;

use FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\Dependency\Client\CustomerPasswordUpdatedAtConnectorToZedRequestClientBridge;
use FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\Dependency\Client\CustomerPasswordUpdatedAtConnectorToZedRequestClientInterface;
use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;

class CustomerPasswordUpdatedAtConnectorDependencyProvider extends AbstractDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_ZED_REQUEST = 'CLIENT_ZED_REQUEST';

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    public function provideServiceLayerDependencies(Container $container): Container
    {
        $container = parent::provideServiceLayerDependencies($container);
        $container = $this->addZedRequestClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addZedRequestClient(Container $container)
    {
        $container[static::CLIENT_ZED_REQUEST] = static function (Container $container): CustomerPasswordUpdatedAtConnectorToZedRequestClientInterface {
            return new CustomerPasswordUpdatedAtConnectorToZedRequestClientBridge(
                $container->getLocator()->zedRequest()->client(),
            );
        };

        return $container;
    }
}
