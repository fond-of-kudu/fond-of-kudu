<?php

namespace FondOfKudu\Zed\OmsPayoneError\Persistence;

use FondOfKudu\Zed\OmsPayoneError\OmsPayoneErrorDependencyProvider;
use Orm\Zed\Payone\Persistence\SpyPaymentPayoneApiLogQuery;
use Orm\Zed\Payone\Persistence\SpyPaymentPayoneQuery;
use Orm\Zed\Sales\Persistence\SpySalesOrderQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfKudu\Zed\OmsPayoneError\OmsPayoneErrorConfig getConfig()
 * @method \FondOfKudu\Zed\OmsPayoneError\Persistence\OmsPayoneErrorQueryContainerInterface getQueryContainer()
 * @method \FondOfKudu\Zed\OmsPayoneError\Persistence\OmsPayoneErrorRepositoryInterface getRepository()
 */
class OmsPayoneErrorPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Sales\Persistence\SpySalesOrderQuery
     */
    public function getSalesOrderPropelQuery(): SpySalesOrderQuery
    {
        return $this->getProvidedDependency(OmsPayoneErrorDependencyProvider::PROPEL_QUERY_SALES_ORDER);
    }

    /**
     * @return \Orm\Zed\Payone\Persistence\SpyPaymentPayoneQuery
     */
    public function getPaymentPayonePropelQuery(): SpyPaymentPayoneQuery
    {
        return $this->getProvidedDependency(OmsPayoneErrorDependencyProvider::PROPEL_QUERY_PAYMENT_PAYONE);
    }

    /**
     * @return \Orm\Zed\Payone\Persistence\SpyPaymentPayoneApiLogQuery
     */
    public function getPaymentPayoneApiLogQuery(): SpyPaymentPayoneApiLogQuery
    {
        return $this->getProvidedDependency(OmsPayoneErrorDependencyProvider::PROPEL_QUERY_PAYMENT_PAYONE_API_LOG);
    }
}
