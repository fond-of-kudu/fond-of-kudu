<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi;

use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionRestApiToProductResourceAliasStorageClientInterface;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\PromotionItemMapper;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\PromotionItemMapperInterface;
use Spryker\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiFactory as SprykerDiscountPromotionsRestApiFactory;

class DiscountPromotionsRestApiFactory extends SprykerDiscountPromotionsRestApiFactory
{
    /**
     * @return \FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\PromotionItemMapperInterface
     */
    public function createPromotionItemMapper(): PromotionItemMapperInterface
    {
        return new PromotionItemMapper($this->getProductResourceAliasStorageClient());
    }

    /**
     * @return \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionRestApiToProductResourceAliasStorageClientInterface
     */
    protected function getProductResourceAliasStorageClient(): DiscountPromotionRestApiToProductResourceAliasStorageClientInterface
    {
        return $this->getProvidedDependency(DiscountPromotionsRestApiDependencyProvider::CLIENT_PRODUCT_RESOURCE_ALIAS);
    }
}
