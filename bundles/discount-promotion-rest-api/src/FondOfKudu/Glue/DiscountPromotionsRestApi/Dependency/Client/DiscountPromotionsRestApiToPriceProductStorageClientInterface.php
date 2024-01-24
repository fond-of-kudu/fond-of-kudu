<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client;

interface DiscountPromotionsRestApiToPriceProductStorageClientInterface
{
    /**
     * @param int $idProductAbstract
     *
     * @return array<\Generated\Shared\Transfer\PriceProductTransfer>
     */
    public function getPriceProductAbstractTransfers(int $idProductAbstract): array;
}
