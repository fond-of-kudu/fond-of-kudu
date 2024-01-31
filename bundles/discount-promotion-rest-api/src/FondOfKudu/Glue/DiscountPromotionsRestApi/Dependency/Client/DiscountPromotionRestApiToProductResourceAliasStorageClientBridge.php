<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client;

use Spryker\Client\ProductResourceAliasStorage\ProductResourceAliasStorageClientInterface;

class DiscountPromotionRestApiToProductResourceAliasStorageClientBridge implements DiscountPromotionRestApiToProductResourceAliasStorageClientInterface
{
    /**
     * @var \Spryker\Client\ProductResourceAliasStorage\ProductResourceAliasStorageClientInterface
     */
    protected ProductResourceAliasStorageClientInterface $productResourceAliasStorageClient;

    /**
     * @param \Spryker\Client\ProductResourceAliasStorage\ProductResourceAliasStorageClientInterface $productResourceAliasStorageClient
     */
    public function __construct(ProductResourceAliasStorageClientInterface $productResourceAliasStorageClient)
    {
        $this->productResourceAliasStorageClient = $productResourceAliasStorageClient;
    }

    /**
     * @api
     *
     * @param array<string> $skus
     * @param string $localeName
     *
     * @return array
     */
    public function getBulkProductAbstractStorageData(array $skus, string $localeName): array
    {
        return $this->productResourceAliasStorageClient->getBulkProductAbstractStorageData($skus, $localeName);
    }
}
