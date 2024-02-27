<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi;

use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionRestApiToProductResourceAliasStorageClientInterface;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToCurrencyClientInterface;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToProductStorageClientInterface;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Service\DiscountPromotionsRestApiToDiscountServiceInterface;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Expander\PromotionItemByQuoteResourceRelationshipExpander;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\DiscountCalculationRequestMapper;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\DiscountCalculationRequestMapperInterface;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\PromotionItemMapper;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\PromotionItemMapperInterface;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\PromotionProductMapper;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\PromotionProductMapperInterface;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\RestProductPriceAttributeMapper;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\RestProductPriceAttributeMapperInterface;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\RestResponseProductImageMapper;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\RestResponseProductImageMapperInterface;
use Spryker\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiFactory as SprykerDiscountPromotionsRestApiFactory;
use Spryker\Glue\DiscountPromotionsRestApi\Processor\Expander\PromotionItemByQuoteResourceRelationshipExpanderInterface;

/**
 * @method \FondOfKudu\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiConfig getConfig()
 */
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
            $this->createDiscountCalculationRequestMapper(),
        );
    }

    /**
     * @return \FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\PromotionProductMapperInterface
     */
    protected function createPromotionProductMapper(): PromotionProductMapperInterface
    {
        return new PromotionProductMapper(
            $this->getConfig(),
            $this->createRestProductPriceAttributeMapper(),
            $this->createRestResponseProductImageMapper(),
        );
    }

    /**
     * @return \FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\RestProductPriceAttributeMapperInterface
     */
    protected function createRestProductPriceAttributeMapper(): RestProductPriceAttributeMapperInterface
    {
        return new RestProductPriceAttributeMapper($this->getCurrencyClient());
    }

    /**
     * @return \FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\DiscountCalculationRequestMapperInterface
     */
    protected function createDiscountCalculationRequestMapper(): DiscountCalculationRequestMapperInterface
    {
        return new DiscountCalculationRequestMapper();
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

    /**
     * @return \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToCurrencyClientInterface
     */
    protected function getCurrencyClient(): DiscountPromotionsRestApiToCurrencyClientInterface
    {
        return $this->getProvidedDependency(DiscountPromotionsRestApiDependencyProvider::CLIENT_CURRENCY);
    }

    /**
     * @return \FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\RestResponseProductImageMapperInterface
     */
    protected function createRestResponseProductImageMapper(): RestResponseProductImageMapperInterface
    {
        return new RestResponseProductImageMapper($this->getConfig());
    }
}
