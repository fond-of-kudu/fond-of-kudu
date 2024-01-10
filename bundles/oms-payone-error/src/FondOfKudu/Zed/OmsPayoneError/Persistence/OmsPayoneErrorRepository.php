<?php

namespace FondOfKudu\Zed\OmsPayoneError\Persistence;

use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfKudu\Zed\OmsPayoneError\Persistence\OmsPayoneErrorPersistenceFactory getFactory()
 */
class OmsPayoneErrorRepository extends AbstractRepository implements OmsPayoneErrorRepositoryInterface
{
    /**
     * @param int $idSalesOrder
     *
     * @return string
     */
    public function findPaymentPayoneApiLogErrorWithIdSalesOrder(int $idSalesOrder): string
    {
        $query = $this->getFactory()->getPaymentPayoneApiLogQuery()
            ->useSpyPaymentPayoneQuery()
                ->filterByFkSalesOrder($idSalesOrder)
            ->endUse()
            ->filterByStatus('ERROR')
            ->orderByCreatedAt(Criteria::DESC)
            ->orderByIdPaymentPayoneApiLog(Criteria::DESC);

        /** @var \Orm\Zed\Payone\Persistence\SpyPaymentPayoneApiLog $spyPaymentPayoneApiLog */
        $spyPaymentPayoneApiLog = $this->buildQueryFromCriteria($query)->findOne();

        return $spyPaymentPayoneApiLog->getErrorCode();
    }
}
