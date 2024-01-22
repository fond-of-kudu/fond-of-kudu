<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client;

interface DiscountPromotionsRestApiToProductStorageClientInterface
{
    /**
     * @param int $idProductAbstract
     * @param string $localeName
     *
     * @return array|null
     */
    public function findProductAbstractStorageData(int $idProductAbstract, string $localeName): ?array;
}
