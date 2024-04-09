<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper;

use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;

interface PriceProductScheduleMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductScheduleTransfer
     */
    public function createFromProductAbstractTransfer(
        ProductAbstractTransfer $productAbstractTransfer,
        PriceProductTransfer $priceProductTransfer
    ): PriceProductScheduleTransfer;

    /**
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     * @param array $attributes
     *
     * @return \Generated\Shared\Transfer\PriceProductScheduleTransfer
     */
    public function createFromProductConcreteTransfer(
        PriceProductTransfer $priceProductTransfer,
        array $attributes
    ): PriceProductScheduleTransfer;
}
