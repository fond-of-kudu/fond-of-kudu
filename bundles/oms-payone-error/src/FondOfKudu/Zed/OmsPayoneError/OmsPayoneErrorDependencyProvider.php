<?php

namespace FondOfKudu\Zed\OmsPayoneError;

use FondOfKudu\Zed\OmsPayoneError\Dependency\Facade\OmsPayoneErrorToPayoneFacadeBridge;
use FondOfKudu\Zed\OmsPayoneError\Dependency\Facade\OmsPayoneErrorToPayoneFacadeInterface;
use Orm\Zed\Payone\Persistence\SpyPaymentPayoneApiLogQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class OmsPayoneErrorDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const PROPEL_QUERY_PAYMENT_PAYONE_API_LOG = 'PROPEL_QUERY_PAYMENT_PAYONE_API_LOG';

    /**
     * @var string
     */
    public const FACADE_PAYONE = 'FACADE_PAYONE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);
        $container = $this->addPayoneFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container)
    {
        $container = parent::providePersistenceLayerDependencies($container);
        $container = $this->addPaymentPayoneApiLogQuery($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPaymentPayoneApiLogQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_PAYMENT_PAYONE_API_LOG] = static fn (): SpyPaymentPayoneApiLogQuery => SpyPaymentPayoneApiLogQuery::create();

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPayoneFacade(Container $container): Container
    {
        $container[static::FACADE_PAYONE] = static fn (
            Container $container
        ): OmsPayoneErrorToPayoneFacadeInterface => new OmsPayoneErrorToPayoneFacadeBridge(
            $container->getLocator()->payone()->facade(),
        );

        return $container;
    }
}
