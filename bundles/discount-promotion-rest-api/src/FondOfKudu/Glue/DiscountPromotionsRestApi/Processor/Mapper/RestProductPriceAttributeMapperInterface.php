<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper;

use Generated\Shared\Transfer\ProductViewTransfer;
use Generated\Shared\Transfer\RestProductPriceAttributesTransfer;

interface RestProductPriceAttributeMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     *
     * @return \Generated\Shared\Transfer\RestProductPriceAttributesTransfer
     */
    public function mapFromProductViewTransfer(
        ProductViewTransfer $productViewTransfer
    ): RestProductPriceAttributesTransfer;
}
