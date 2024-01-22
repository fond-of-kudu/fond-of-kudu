<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Expander;

use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToProductStorageClientInterface;
use Generated\Shared\Transfer\RestPromotionalItemsAttributesTransfer;
use Spryker\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiConfig;
use Spryker\Glue\DiscountPromotionsRestApi\Processor\Expander\PromotionItemByQuoteResourceRelationshipExpander as SprykerPromotionItemByQuoteResourceRelationshipExpander;
use Spryker\Glue\DiscountPromotionsRestApi\Processor\Mapper\PromotionItemMapperInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class PromotionItemByQuoteResourceRelationshipExpander extends SprykerPromotionItemByQuoteResourceRelationshipExpander
{
    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToProductStorageClientInterface
     */
    protected DiscountPromotionsRestApiToProductStorageClientInterface $productStorageClient;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \Spryker\Glue\DiscountPromotionsRestApi\Processor\Mapper\PromotionItemMapperInterface $promotionItemMapper
     * @param \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToProductStorageClientInterface $productStorageClient
     */
    public function __construct(
        RestResourceBuilderInterface $restResourceBuilder,
        PromotionItemMapperInterface $promotionItemMapper,
        DiscountPromotionsRestApiToProductStorageClientInterface $productStorageClient
    ) {
        parent::__construct($restResourceBuilder, $promotionItemMapper);

        $this->productStorageClient = $productStorageClient;
    }

    /**
     * @param array<\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface> $resources
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return void
     */
    public function addResourceRelationships(array $resources, RestRequestInterface $restRequest): void
    {
        foreach ($resources as $resource) {
            $promotionItemTransfers = $this->getPromotionItemsFromPayload($resource);
            $promotionItemTransfers = $this->filterDiscountPromotionDuplicates($promotionItemTransfers);

            foreach ($promotionItemTransfers as $promotionItemTransfer) {
                $restPromotionalItemsAttributesTransfer = $this->promotionItemMapper
                    ->mapPromotionItemTransferToRestPromotionalItemsAttributesTransfer(
                        $promotionItemTransfer,
                        new RestPromotionalItemsAttributesTransfer(),
                    );

                $promotionalItemsResource = $this->restResourceBuilder->createRestResource(
                    DiscountPromotionsRestApiConfig::RESOURCE_PROMOTIONAL_ITEMS,
                    $this->findDiscountPromotionUuid($promotionItemTransfer),
                    $restPromotionalItemsAttributesTransfer,
                );

                $resource->addRelationship($promotionalItemsResource);
            }
        }
    }
}
