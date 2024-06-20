<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector;

use FondOfKudu\Glue\CustomersRestApiConnector\Dependency\Client\CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientBridge;
use FondOfKudu\Glue\CustomersRestApiConnector\Dependency\Client\CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientInterface;
use Spryker\Glue\Kernel\AbstractBundleDependencyProvider;
use Spryker\Glue\Kernel\Container;

class CustomersRestApiConnectorDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_CUSTOMER_PASSWORD_UPDATE_AT_CONNECTOR = 'CLIENT_CUSTOMER_PASSWORD_UPDATE_AT_CONNECTOR';

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = $this->addCustomerPasswordUpdateAtConnectorClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addCustomerPasswordUpdateAtConnectorClient(Container $container): Container
    {
        $container->set(
            static::CLIENT_CUSTOMER_PASSWORD_UPDATE_AT_CONNECTOR,
            static fn (Container $container): CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientInterface => new CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientBridge(
                $container->getLocator()->customerPasswordUpdatedAtConnector()->client(),
            ),
        );

        return $container;
    }
}
