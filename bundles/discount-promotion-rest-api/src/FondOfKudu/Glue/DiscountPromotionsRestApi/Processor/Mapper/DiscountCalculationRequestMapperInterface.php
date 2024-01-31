<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper;

use Generated\Shared\Transfer\DiscountCalculationRequestTransfer;
use Generated\Shared\Transfer\DiscountTransfer;

interface DiscountCalculationRequestMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\DiscountTransfer $discountTransfer
     * @param int $productPrice
     *
     * @return \Generated\Shared\Transfer\DiscountCalculationRequestTransfer
     */
    public function mapFromDiscountTransfer(
        DiscountTransfer $discountTransfer,
        int $productPrice
    ): DiscountCalculationRequestTransfer;
}
