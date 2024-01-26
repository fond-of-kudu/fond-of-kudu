<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi;

use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionRestApiToProductResourceAliasStorageClientInterface;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToProductStorageClientInterface;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Service\DiscountPromotionsRestApiToDiscountServiceInterface;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Expander\PromotionItemByQuoteResourceRelationshipExpander;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\PromotionItemMapper;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\PromotionItemMapperInterface;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\PromotionProductMapper;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\PromotionProductMapperInterface;
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
        );
    }

    /**
     * @return \FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\PromotionItemMapperInterface
     */
    public function createPromotionItemMapper(): PromotionItemMapperInterface
    {
        return new PromotionItemMapper(
            $this->getProductResourceAliasStorageClient(),
            $this->getProductStorageClient(),
            $this->getDiscountService(),
            $this->createPromotionProductMapper(),
        );
    }

    /**
     * @return \FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\PromotionProductMapperInterface
     */
    protected function createPromotionProductMapper(): PromotionProductMapperInterface
    {
        return new PromotionProductMapper();
    }

    /**
     * @return \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionRestApiToProductResourceAliasStorageClientInterface
     */
    protected function getProductResourceAliasStorageClient(): DiscountPromotionRestApiToProductResourceAliasStorageClientInterface
    {
        return $this->getProvidedDependency(DiscountPromotionsRestApiDependencyProvider::CLIENT_PRODUCT_RESOURCE_ALIAS);
    }

    /**
     * @return \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToProductStorageClientInterface
     */
    protected function getProductStorageClient(): DiscountPromotionsRestApiToProductStorageClientInterface
    {
        return $this->getProvidedDependency(DiscountPromotionsRestApiDependencyProvider::CLIENT_PRODUCT_STORAGE);
    }

    /**
     * @return \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Service\DiscountPromotionsRestApiToDiscountServiceInterface
     */
    protected function getDiscountService(): DiscountPromotionsRestApiToDiscountServiceInterface
    {
        return $this->getProvidedDependency(DiscountPromotionsRestApiDependencyProvider::SERVICE_DISCOUNT);
    }
}
