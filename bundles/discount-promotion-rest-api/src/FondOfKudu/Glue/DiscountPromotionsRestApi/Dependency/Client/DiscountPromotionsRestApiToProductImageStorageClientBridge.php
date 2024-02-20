<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client;

use Spryker\Client\ProductImageStorage\ProductImageStorageClientInterface;

class DiscountPromotionsRestApiToProductImageStorageClientBridge implements DiscountPromotionsRestApiToProductImageStorageClientInterface
{
    /**
     * @var \Spryker\Client\ProductImageStorage\ProductImageStorageClientInterface
     */
    protected ProductImageStorageClientInterface $productImageStorageClient;

    /**
     * @param \Spryker\Client\ProductImageStorage\ProductImageStorageClientInterface $productImageStorageClient
     */
    public function __construct(ProductImageStorageClientInterface $productImageStorageClient)
    {
        $this->productImageStorageClient = $productImageStorageClient;
    }

    /**
     * @param int $idProductConcrete
     * @param int $idProductAbstract
     * @param string $locale
     *
     * @return array<\Generated\Shared\Transfer\ProductImageSetStorageTransfer>|null
     */
    public function resolveProductImageSetStorageTransfers(
        int $idProductConcrete,
        int $idProductAbstract,
        string $locale
    ): ?array {
        return $this->productImageStorageClient->resolveProductImageSetStorageTransfers(
            $idProductConcrete,
            $idProductAbstract,
            $locale,
        );
    }
}
