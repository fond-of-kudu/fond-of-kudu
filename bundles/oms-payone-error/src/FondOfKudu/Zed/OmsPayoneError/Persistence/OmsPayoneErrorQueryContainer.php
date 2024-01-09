<?php

namespace FondOfKudu\Zed\OmsPayoneError\Persistence;

use Orm\Zed\Payone\Persistence\SpyPaymentPayoneApiLogQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @method \FondOfKudu\Zed\OmsPayoneError\Persistence\OmsPayoneErrorPersistenceFactory getFactory()()
 * @method \FondOfKudu\Zed\OmsPayoneError\Persistence\OmsPayoneErrorQueryContainerInterface getQueryContainer()
 * @method \FondOfKudu\Zed\OmsPayoneError\Persistence\OmsPayoneErrorRepositoryInterface getRepository()
 * @method \FondOfKudu\Zed\OmsPayoneError\OmsPayoneErrorConfig getConfig()
 */
class OmsPayoneErrorQueryContainer extends AbstractQueryContainer implements OmsPayoneErrorQueryContainerInterface
{
    /**
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Payone\Persistence\SpyPaymentPayoneApiLogQuery|null
     */
    public function createApiLogsByOrderId(int $idSalesOrder): ?SpyPaymentPayoneApiLogQuery
    {
        return $this->getFactory()->getPaymentPayoneApiLogQuery()
            ->useSpyPaymentPayoneQuery()
                ->filterByFkSalesOrder($idSalesOrder)
            ->endUse()
            ->orderByCreatedAt(Criteria::DESC)
            ->orderByIdPaymentPayoneApiLog(Criteria::DESC);
    }
}
