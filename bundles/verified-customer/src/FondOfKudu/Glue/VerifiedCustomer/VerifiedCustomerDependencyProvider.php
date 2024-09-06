<?php

namespace FondOfKudu\Glue\VerifiedCustomer;

use FondOfKudu\Glue\VerifiedCustomer\Dependency\Client\VerifiedCustomerToCustomerBridge;
use Spryker\Glue\Kernel\AbstractBundleDependencyProvider;
use Spryker\Glue\Kernel\Container;

class VerifiedCustomerDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_CUSTOMER = 'CLIENT_CUSTOMER';

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        return $this->addCustomerClient($container);
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    private function addCustomerClient(Container $container): Container
    {
        $container[self::CLIENT_CUSTOMER] = function (Container $container) {
            return new VerifiedCustomerToCustomerBridge($container->getLocator()->customer()->client());
        };

        return $container;
    }
}
