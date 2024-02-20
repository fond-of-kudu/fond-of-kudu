<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client;

interface DiscountPromotionsRestApiToProductImageStorageClientInterface
{
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
    ): ?array;
}
