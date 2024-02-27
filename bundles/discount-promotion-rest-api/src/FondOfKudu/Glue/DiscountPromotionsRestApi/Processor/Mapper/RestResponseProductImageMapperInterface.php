<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper;

use Generated\Shared\Transfer\ProductViewTransfer;

interface RestResponseProductImageMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     *
     * @return array
     */
    public function mapFromProductViewTransfer(ProductViewTransfer $productViewTransfer): array;
}
