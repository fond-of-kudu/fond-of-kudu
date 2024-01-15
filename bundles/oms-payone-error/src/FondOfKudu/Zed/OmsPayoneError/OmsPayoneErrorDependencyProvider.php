<?php

namespace FondOfKudu\Zed\OmsPayoneError;

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
}
