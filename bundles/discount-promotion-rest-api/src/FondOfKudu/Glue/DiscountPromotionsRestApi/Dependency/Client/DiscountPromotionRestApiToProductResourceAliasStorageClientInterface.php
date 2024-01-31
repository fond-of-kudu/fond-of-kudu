<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client;

interface DiscountPromotionRestApiToProductResourceAliasStorageClientInterface
{
    /**
     * @api
     *
     * @param array<string> $skus
     * @param string $localeName
     *
     * @return array
     */
    public function getBulkProductAbstractStorageData(array $skus, string $localeName): array;
}
