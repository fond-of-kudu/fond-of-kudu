<?php

namespace FondOfKudu\Zed\OmsPayoneError\Persistence;

use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;
use Spryker\Zed\PropelOrm\Business\Runtime\ActiveQuery\Criteria as SprykerCriteria;

/**
 * @method \FondOfKudu\Zed\OmsPayoneError\Persistence\OmsPayoneErrorPersistenceFactory getFactory()
 */
class OmsPayoneErrorRepository extends AbstractRepository implements OmsPayoneErrorRepositoryInterface
{
    /**
     * @param int $idSalesOrder
     * @param array $errorCodeBetween
     *
     * @return bool
     */
    public function isPaymentPayoneApiLogErrorWithIdSalesOrderAndErrorCodeBetween(
        int $idSalesOrder,
        array $errorCodeBetween
    ): bool {
        $query = $this->getFactory()->getPaymentPayoneApiLogQuery()
            ->useSpyPaymentPayoneQuery()
                ->filterByFkSalesOrder($idSalesOrder)
            ->endUse()
            ->filterByStatus('ERROR')
            ->filterByErrorCode($errorCodeBetween, SprykerCriteria::BETWEEN)
            ->orderByCreatedAt(Criteria::DESC)
            ->orderByIdPaymentPayoneApiLog(Criteria::DESC);

        $spyPaymentPayoneApiLog = $this->buildQueryFromCriteria($query)->findOne();

        return $spyPaymentPayoneApiLog !== null;
    }
}
