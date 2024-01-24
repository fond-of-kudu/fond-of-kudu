<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper;

use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionRestApiToProductResourceAliasStorageClientInterface;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToPriceProductStorageClientInterface;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Service\DiscountPromotionsRestApiToDiscountServiceInterface;
use Generated\Shared\Transfer\RestPromotionalItemsAttributesTransfer;
use Spryker\Glue\DiscountPromotionsRestApi\Processor\Mapper\PromotionItemMapper as SprykerPromotionItemMapper;

class PromotionItemMapper extends SprykerPromotionItemMapper implements PromotionItemMapperInterface
{
    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionRestApiToProductResourceAliasStorageClientInterface
     */
    protected DiscountPromotionRestApiToProductResourceAliasStorageClientInterface $productResourceAliasStorageClient;

    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToPriceProductStorageClientInterface
     */
    protected DiscountPromotionsRestApiToPriceProductStorageClientInterface $priceProductStorageClient;

    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Service\DiscountPromotionsRestApiToDiscountServiceInterface
     */
    protected DiscountPromotionsRestApiToDiscountServiceInterface $discountService;

    /**
     * @param \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionRestApiToProductResourceAliasStorageClientInterface $productResourceAliasStorageClient
     * @param \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToPriceProductStorageClientInterface $priceProductStorageClient
     * @param \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Service\DiscountPromotionsRestApiToDiscountServiceInterface $discountService
     */
    public function __construct(
        DiscountPromotionRestApiToProductResourceAliasStorageClientInterface $productResourceAliasStorageClient,
        DiscountPromotionsRestApiToPriceProductStorageClientInterface $priceProductStorageClient,
        DiscountPromotionsRestApiToDiscountServiceInterface $discountService
    ) {
        $this->productResourceAliasStorageClient = $productResourceAliasStorageClient;
        $this->priceProductStorageClient = $priceProductStorageClient;
        $this->discountService = $discountService;
    }

    /**
     * @param \Generated\Shared\Transfer\RestPromotionalItemsAttributesTransfer $restPromotionalItemsAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestPromotionalItemsAttributesTransfer
     */
    public function mapPromotedProductsToRestPromotionalItemsAttributesTransfer(
        RestPromotionalItemsAttributesTransfer $restPromotionalItemsAttributesTransfer
    ): RestPromotionalItemsAttributesTransfer {
        if (count($restPromotionalItemsAttributesTransfer->getSkus()) === 0) {
            return $restPromotionalItemsAttributesTransfer;
        }

        $promotedProducts = $this->productResourceAliasStorageClient->getBulkProductAbstractStorageData(
            $restPromotionalItemsAttributesTransfer->getSkus(),
            'de_DE',
        );

        $restPromotionalItemsAttributesTransfer->addPromotedProduct($promotedProducts);

        return $restPromotionalItemsAttributesTransfer;
    }
}
