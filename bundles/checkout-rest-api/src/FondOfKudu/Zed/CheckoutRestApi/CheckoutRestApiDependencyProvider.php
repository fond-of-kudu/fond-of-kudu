<?php

namespace FondOfKudu\Zed\CheckoutRestApi;

use FondOfKudu\Zed\CheckoutRestApi\Dependency\Facade\CheckoutRestApiToQuoteFacadeBridge;
use Spryker\Zed\CheckoutRestApi\CheckoutRestApiDependencyProvider as SprykerCheckoutRestApiDependencyProvider;
use Spryker\Zed\Kernel\Container;

class CheckoutRestApiDependencyProvider extends SprykerCheckoutRestApiDependencyProvider
{
    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addQuoteFacade(Container $container): Container
    {
        $container->set(static::FACADE_QUOTE, function (Container $container) {
            return new CheckoutRestApiToQuoteFacadeBridge($container->getLocator()->quote()->facade());
        });

        return $container;
    }
}
