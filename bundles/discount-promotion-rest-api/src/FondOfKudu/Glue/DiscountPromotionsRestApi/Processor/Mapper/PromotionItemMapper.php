<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper;

use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionRestApiToProductResourceAliasStorageClientInterface;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToProductStorageClientInterface;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Service\DiscountPromotionsRestApiToDiscountServiceInterface;
use Generated\Shared\Transfer\PromotionItemTransfer;
use Generated\Shared\Transfer\RestPromotionalItemsAttributesTransfer;
use Spryker\Glue\DiscountPromotionsRestApi\Processor\Mapper\PromotionItemMapper as SprykerPromotionItemMapper;

class PromotionItemMapper extends SprykerPromotionItemMapper implements PromotionItemMapperInterface
{
    /**
     * @var string
     */
    public const ID_PRODUCT_ABSTRACT = 'id_product_abstract';

    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionRestApiToProductResourceAliasStorageClientInterface
     */
    protected DiscountPromotionRestApiToProductResourceAliasStorageClientInterface $productResourceAliasStorageClient;

    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToProductStorageClientInterface
     */
    protected DiscountPromotionsRestApiToProductStorageClientInterface $productStorageClient;

    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Service\DiscountPromotionsRestApiToDiscountServiceInterface
     */
    protected DiscountPromotionsRestApiToDiscountServiceInterface $discountService;

    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\PromotionProductMapperInterface
     */
    protected PromotionProductMapperInterface $promotionProductMapper;

    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\DiscountCalculationRequestMapperInterface
     */
    protected DiscountCalculationRequestMapperInterface $discountCalculationRequestMapper;

    /**
     * @param \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionRestApiToProductResourceAliasStorageClientInterface $productResourceAliasStorageClient
     * @param \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToProductStorageClientInterface $productStorageClient
     * @param \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Service\DiscountPromotionsRestApiToDiscountServiceInterface $discountService
     * @param \FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\PromotionProductMapperInterface $promotionProductMapper
     * @param \FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\DiscountCalculationRequestMapperInterface $discountCalculationRequestMapper
     */
    public function __construct(
        DiscountPromotionRestApiToProductResourceAliasStorageClientInterface $productResourceAliasStorageClient,
        DiscountPromotionsRestApiToProductStorageClientInterface $productStorageClient,
        DiscountPromotionsRestApiToDiscountServiceInterface $discountService,
        PromotionProductMapperInterface $promotionProductMapper,
        DiscountCalculationRequestMapperInterface $discountCalculationRequestMapper
    ) {
        $this->productResourceAliasStorageClient = $productResourceAliasStorageClient;
        $this->productStorageClient = $productStorageClient;
        $this->discountService = $discountService;
        $this->promotionProductMapper = $promotionProductMapper;
        $this->discountCalculationRequestMapper = $discountCalculationRequestMapper;
    }

    /**
     * @param \Generated\Shared\Transfer\RestPromotionalItemsAttributesTransfer $restPromotionalItemsAttributesTransfer
     * @param \Generated\Shared\Transfer\PromotionItemTransfer $promotionItemTransfer
     * @param string $locale
     *
     * @return \Generated\Shared\Transfer\RestPromotionalItemsAttributesTransfer
     */
    public function mapPromotedProductsToRestPromotionalItemsAttributesTransfer(
        RestPromotionalItemsAttributesTransfer $restPromotionalItemsAttributesTransfer,
        PromotionItemTransfer $promotionItemTransfer,
        string $locale
    ): RestPromotionalItemsAttributesTransfer {
        if (count($restPromotionalItemsAttributesTransfer->getSkus()) === 0) {
            return $restPromotionalItemsAttributesTransfer;
        }

        $productsData = $this->productResourceAliasStorageClient->getBulkProductAbstractStorageData(
            $restPromotionalItemsAttributesTransfer->getSkus(),
            $locale,
        );

        foreach ($productsData as $productData) {
            if (!isset($productData[static::ID_PRODUCT_ABSTRACT])) {
                continue;
            }

            $productViewTransfer = $this->productStorageClient
                ->findProductAbstractViewTransfer($productData[static::ID_PRODUCT_ABSTRACT], $locale);

            if ($productViewTransfer === null) {
                continue;
            }

            $discountCalculationRequestTransfer = $this->discountCalculationRequestMapper
                ->mapFromDiscountTransfer(
                    $promotionItemTransfer->getDiscount(),
                    $productViewTransfer->getPrice(),
                );

            $discountCalculationResponseTransfer = $this->discountService->calculate($discountCalculationRequestTransfer);

            $promotedProductTransfer = $this->promotionProductMapper
                ->mapProductViewTransferToRestPromotionalProductTransfer(
                    $productViewTransfer,
                    $discountCalculationResponseTransfer->getAmount(),
                    $promotionItemTransfer->getUuid(),
                );

            if ($promotedProductTransfer === null) {
                continue;
            }

            $restPromotionalItemsAttributesTransfer->addPromotedProduct($promotedProductTransfer);
        }

        return $restPromotionalItemsAttributesTransfer;
    }
}
