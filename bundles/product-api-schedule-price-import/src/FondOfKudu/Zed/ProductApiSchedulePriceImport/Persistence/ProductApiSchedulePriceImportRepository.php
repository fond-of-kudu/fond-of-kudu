<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence;

use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportPersistenceFactory getFactory()
 */
class ProductApiSchedulePriceImportRepository extends AbstractRepository implements ProductApiSchedulePriceImportRepositoryInterface
{
    /**
     * @param int $idProductAbstract
     *
     * @return \Generated\Shared\Transfer\PriceProductScheduleTransfer|null
     */
    public function findLatestPriceProductScheduleByIdProductAbstract(
        int $idProductAbstract
    ): ?PriceProductScheduleTransfer {
        return $this->getFactory()
            ->createPriceProductScheduleFinder()
            ->findLatestPriceProductScheduleByIdProductAbstract($idProductAbstract);
    }
}
