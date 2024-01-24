<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Service;

use Generated\Shared\Transfer\DiscountCalculationRequestTransfer;
use Generated\Shared\Transfer\DiscountCalculationResponseTransfer;

interface DiscountPromotionsRestApiToDiscountServiceInterface
{
    /**
     * @param \Generated\Shared\Transfer\DiscountCalculationRequestTransfer $discountCalculationRequestTransfer
     *
     * @return \Generated\Shared\Transfer\DiscountCalculationResponseTransfer
     */
    public function calculate(
        DiscountCalculationRequestTransfer $discountCalculationRequestTransfer
    ): DiscountCalculationResponseTransfer;
}
