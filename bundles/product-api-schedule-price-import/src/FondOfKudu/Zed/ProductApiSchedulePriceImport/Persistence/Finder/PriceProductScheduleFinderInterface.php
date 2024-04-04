<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\Finder;

use Generated\Shared\Transfer\PriceProductScheduleTransfer;

interface PriceProductScheduleFinderInterface
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
