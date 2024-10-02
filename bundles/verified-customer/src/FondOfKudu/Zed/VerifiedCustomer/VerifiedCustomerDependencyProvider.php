<?php

namespace FondOfKudu\Zed\VerifiedCustomer;

use FondOfKudu\Zed\VerifiedCustomer\Dependency\Facade\VerifiedCustomerToMailBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class VerifiedCustomerDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_MAIL = 'FACADE_MAIL';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        return $this->addMailFacade($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addMailFacade(Container $container): Container
    {
        $container[static::FACADE_MAIL] = function (Container $container) {
            return new VerifiedCustomerToMailBridge($container->getLocator()->mail()->facade());
        };

        return $container;
    }
}
