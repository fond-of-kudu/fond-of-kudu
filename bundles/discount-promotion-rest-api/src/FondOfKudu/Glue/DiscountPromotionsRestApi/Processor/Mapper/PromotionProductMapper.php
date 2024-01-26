<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper;

use Generated\Shared\Transfer\ProductViewTransfer;
use Generated\Shared\Transfer\RestPromotionalProductTransfer;

class PromotionProductMapper implements PromotionProductMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     * @param int $discountAmount
     *
     * @return \Generated\Shared\Transfer\RestPromotionalProductTransfer
     */
    public function mapProductViewTransferToRestPromotionalProductTransfer(
        ProductViewTransfer $productViewTransfer,
        int $discountAmount
    ): RestPromotionalProductTransfer {
        return (new RestPromotionalProductTransfer())
            ->fromArray($productViewTransfer->toArray(), true)
            ->setDiscountPrice($productViewTransfer->getPrice() - $discountAmount);
    }
}
