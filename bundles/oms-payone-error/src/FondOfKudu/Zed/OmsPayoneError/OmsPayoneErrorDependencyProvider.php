<?php

namespace FondOfKudu\Zed\OmsPayoneError;

use Orm\Zed\Payone\Persistence\SpyPaymentPayoneApiLogQuery;
use Orm\Zed\Payone\Persistence\SpyPaymentPayoneQuery;
use Orm\Zed\Sales\Persistence\SpySalesOrderQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class OmsPayoneErrorDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const PROPEL_QUERY_SALES_ORDER = 'PROPEL_QUERY_SALES_ORDER';

    /**
     * @var string
     */
    public const PROPEL_QUERY_PAYMENT_PAYONE = 'PROPEL_QUERY_PAYMENT_PAYONE';

    /**
     * @var string
     */
    public const PROPEL_QUERY_PAYMENT_PAYONE_API_LOG = 'PROPEL_QUERY_PAYMENT_PAYONE_API_LOG';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        return parent::provideBusinessLayerDependencies($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container = parent::providePersistenceLayerDependencies($container);
        $container = $this->addSalesOrderPropelQuery($container);
        $container = $this->addPaymentPayonePropelQuery($container);
        $container = $this->addPaymentPayoneApiLogQuery($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addSalesOrderPropelQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_SALES_ORDER] = static fn (
            Container $container
        ) => SpySalesOrderQuery::create();

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPaymentPayonePropelQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_PAYMENT_PAYONE] = static fn (
            Container $container
        ) => SpyPaymentPayoneQuery::create();

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPaymentPayoneApiLogQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_PAYMENT_PAYONE_API_LOG] = static fn (
            Container $container
        ) => SpyPaymentPayoneApiLogQuery::create();

        return $container;
    }
}
