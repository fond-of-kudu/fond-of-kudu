<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence;

use Generated\Shared\Transfer\PriceProductScheduleTransfer;

interface ProductApiSchedulePriceImportRepositoryInterface
{
    /**
     * @param int $idProductAbstract
     *
     * @return \Generated\Shared\Transfer\PriceProductScheduleTransfer|null
     */
    public function findLatestPriceProductScheduleByIdProductAbstract(
        int $idProductAbstract
    ): ?PriceProductScheduleTransfer;
}
