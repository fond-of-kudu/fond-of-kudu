<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper;

use Generated\Shared\Transfer\DiscountableItemTransfer;
use Generated\Shared\Transfer\DiscountCalculationRequestTransfer;
use Generated\Shared\Transfer\DiscountTransfer;

class DiscountCalculationRequestMapper implements DiscountCalculationRequestMapperInterface
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
    ): DiscountCalculationRequestTransfer {
        $discountableItemTransfer = (new DiscountableItemTransfer())
            ->setUnitPrice($productPrice);

        return (new DiscountCalculationRequestTransfer())
            ->addDiscountableItem($discountableItemTransfer)
            ->setDiscount($discountTransfer);
    }
}
