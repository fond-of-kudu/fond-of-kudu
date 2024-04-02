<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client;

interface DiscountPromotionRestApiToPriceProductStorageClientInterface
{
    /**
     * Specification:
     *  - Returns abstract product prices from Storage.
     *
     * @api
     *
     * @param int $idProductAbstract
     *
     * @return array<\Generated\Shared\Transfer\PriceProductTransfer>
     */
    public function getPriceProductAbstractTransfers(int $idProductAbstract): array;
}
