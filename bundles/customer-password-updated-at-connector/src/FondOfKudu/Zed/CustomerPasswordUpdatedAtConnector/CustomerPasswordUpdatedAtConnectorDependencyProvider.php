<?php

namespace FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector;

use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\Facade\CustomerPasswordUpdatedAtConnectorMailFacadeBridge;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\Facade\CustomerPasswordUpdatedAtConnectorMailFacadeInterface;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\QueryContainer\CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerBridge;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\QueryContainer\CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerInterface;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class CustomerPasswordUpdatedAtConnectorDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const QUERY_CONTAINER_CUSTOMER = 'QUERY_CONTAINER_CUSTOMER';

    /**
     * @var string
     */
    public const FACADE_MAIL = 'FACADE_MAIL';

    /**
     * @var string
     */
    public const PLUGINS_CUSTOMER_TRANSFER_EXPANDER = 'PLUGINS_CUSTOMER_TRANSFER_EXPANDER';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = $this->addCustomerQueryContainer($container);
        $container = $this->addCustomerTransferExpanderPlugins($container);
        $container = $this->addMailFacade($container);
        $container = $this->addCustomerQueryContainer($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCustomerQueryContainer(Container $container): Container
    {
        $container->set(static::QUERY_CONTAINER_CUSTOMER, function (Container $container): CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerInterface {
            return new CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerBridge(
                $container->getLocator()->customer()->queryContainer(),
            );
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCustomerTransferExpanderPlugins(Container $container)
    {
        $container->set(static::PLUGINS_CUSTOMER_TRANSFER_EXPANDER, function () {
            return $this->getCustomerTransferExpanderPlugins();
        });

        return $container;
    }

    /**
     * @return array<\Spryker\Zed\Customer\Dependency\Plugin\CustomerTransferExpanderPluginInterface>
     */
    protected function getCustomerTransferExpanderPlugins(): array
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addMailFacade(Container $container): Container
    {
        $container->set(static::FACADE_MAIL, function (Container $container): CustomerPasswordUpdatedAtConnectorMailFacadeInterface {
            return new CustomerPasswordUpdatedAtConnectorMailFacadeBridge($container->getLocator()->mail()->facade());
        });

        return $container;
    }
}
