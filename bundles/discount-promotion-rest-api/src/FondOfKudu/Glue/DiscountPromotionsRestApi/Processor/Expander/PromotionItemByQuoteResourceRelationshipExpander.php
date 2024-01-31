<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Expander;

use Generated\Shared\Transfer\RestPromotionalItemsAttributesTransfer;
use Spryker\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiConfig;
use Spryker\Glue\DiscountPromotionsRestApi\Processor\Expander\PromotionItemByQuoteResourceRelationshipExpander as SprykerPromotionItemByQuoteResourceRelationshipExpander;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class PromotionItemByQuoteResourceRelationshipExpander extends SprykerPromotionItemByQuoteResourceRelationshipExpander
{
    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\PromotionItemMapperInterface
     */
    protected $promotionItemMapper;

    /**
     * @param array<\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface> $resources
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return void
     */
    public function addResourceRelationships(array $resources, RestRequestInterface $restRequest): void
    {
        $locale = $restRequest->getMetadata()->getLocale();

        foreach ($resources as $resource) {
            $promotionItemTransfers = $this->getPromotionItemsFromPayload($resource);
            $promotionItemTransfers = $this->filterDiscountPromotionDuplicates($promotionItemTransfers);

            foreach ($promotionItemTransfers as $promotionItemTransfer) {
                $restPromotionalItemsAttributesTransfer = $this->promotionItemMapper
                    ->mapPromotionItemTransferToRestPromotionalItemsAttributesTransfer(
                        $promotionItemTransfer,
                        new RestPromotionalItemsAttributesTransfer(),
                    );

                $restPromotionalItemsAttributesTransfer = $this->promotionItemMapper
                    ->mapPromotedProductsToRestPromotionalItemsAttributesTransfer(
                        $restPromotionalItemsAttributesTransfer,
                        $promotionItemTransfer,
                        $locale,
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
