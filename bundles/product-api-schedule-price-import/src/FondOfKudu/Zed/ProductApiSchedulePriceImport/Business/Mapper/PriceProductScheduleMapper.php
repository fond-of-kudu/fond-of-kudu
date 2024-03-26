<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper;

use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;

class PriceProductScheduleMapper implements PriceProductScheduleMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductScheduleTransfer
     */
    public function fromProductAbstractTransfer(
        ProductAbstractTransfer $productAbstractTransfer
    ): PriceProductScheduleTransfer {
        $priceProductScheduleTransfer = new PriceProductScheduleTransfer();

        return $priceProductScheduleTransfer;
    }
}
