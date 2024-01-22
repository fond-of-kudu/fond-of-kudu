<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi;

use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToProductStorageClientInterface;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Expander\PromotionItemByQuoteResourceRelationshipExpander;
use Spryker\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiFactory as SprykerDiscountPromotionsRestApiFactory;
use Spryker\Glue\DiscountPromotionsRestApi\Processor\Expander\PromotionItemByQuoteResourceRelationshipExpanderInterface;

class DiscountPromotionsRestApiFactory extends SprykerDiscountPromotionsRestApiFactory
{
    /**
     * @return \Spryker\Glue\DiscountPromotionsRestApi\Processor\Expander\PromotionItemByQuoteResourceRelationshipExpanderInterface
     */
    public function createPromotionItemByQuoteResourceRelationshipExpander(): PromotionItemByQuoteResourceRelationshipExpanderInterface
    {
        return new PromotionItemByQuoteResourceRelationshipExpander(
            $this->getResourceBuilder(),
            $this->createPromotionItemMapper(),
            $this->getProductStorageClient(),
        );
    }

    /**
     * @return \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToProductStorageClientInterface
     */
    protected function getProductStorageClient(): DiscountPromotionsRestApiToProductStorageClientInterface
    {
        return $this->getProvidedDependency(DiscountPromotionsRestApiDependencyProvider::CLIENT_PRODUCT_STORAGE);
    }
}
