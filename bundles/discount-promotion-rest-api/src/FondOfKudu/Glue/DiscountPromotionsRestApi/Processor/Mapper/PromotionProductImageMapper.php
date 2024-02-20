<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper;

use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToProductImageStorageClientInterface;
use Generated\Shared\Transfer\ProductViewTransfer;

class PromotionProductImageMapper
{
    protected DiscountPromotionsRestApiToProductImageStorageClientInterface $productImageStorageClient;

    /**
     * @param \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToProductImageStorageClientInterface $productImageStorageClient
     */
    public function __construct(DiscountPromotionsRestApiToProductImageStorageClientInterface $productImageStorageClient)
    {
        $this->productImageStorageClient = $productImageStorageClient;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     * @param string $locale
     *
     * @return array
     */
    public function map(ProductViewTransfer $productViewTransfer, string $locale): array
    {
        return $this->productImageStorageClient
            ->resolveProductImageSetStorageTransfers(
                $productViewTransfer->getIdProductAbstract(),
                $productViewTransfer->getIdProductConcrete(),
                $locale,
            );
    }
}
