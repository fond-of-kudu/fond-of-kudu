<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper;

use ArrayObject;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionRestApiToProductResourceAliasStorageClientInterface;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToProductStorageClientInterface;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Service\DiscountPromotionsRestApiToDiscountServiceInterface;
use Generated\Shared\Transfer\DiscountableItemTransfer;
use Generated\Shared\Transfer\DiscountCalculationRequestTransfer;
use Generated\Shared\Transfer\DiscountTransfer;
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
     * @param \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionRestApiToProductResourceAliasStorageClientInterface $productResourceAliasStorageClient
     * @param \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToProductStorageClientInterface $productStorageClient
     * @param \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Service\DiscountPromotionsRestApiToDiscountServiceInterface $discountService
     * @param \FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\PromotionProductMapperInterface $promotionProductMapper
     */
    public function __construct(
        DiscountPromotionRestApiToProductResourceAliasStorageClientInterface $productResourceAliasStorageClient,
        DiscountPromotionsRestApiToProductStorageClientInterface $productStorageClient,
        DiscountPromotionsRestApiToDiscountServiceInterface $discountService,
        PromotionProductMapperInterface $promotionProductMapper
    ) {
        $this->productResourceAliasStorageClient = $productResourceAliasStorageClient;
        $this->productStorageClient = $productStorageClient;
        $this->discountService = $discountService;
        $this->promotionProductMapper = $promotionProductMapper;
    }

    /**
     * @param \Generated\Shared\Transfer\RestPromotionalItemsAttributesTransfer $restPromotionalItemsAttributesTransfer
     * @param \Generated\Shared\Transfer\PromotionItemTransfer $promotionItemTransfer
     *
     * @return \Generated\Shared\Transfer\RestPromotionalItemsAttributesTransfer
     */
    public function mapPromotedProductsToRestPromotionalItemsAttributesTransfer(
        RestPromotionalItemsAttributesTransfer $restPromotionalItemsAttributesTransfer,
        PromotionItemTransfer $promotionItemTransfer
    ): RestPromotionalItemsAttributesTransfer {
        if (count($restPromotionalItemsAttributesTransfer->getSkus()) === 0) {
            return $restPromotionalItemsAttributesTransfer;
        }

        $productsData = $this->productResourceAliasStorageClient->getBulkProductAbstractStorageData(
            $restPromotionalItemsAttributesTransfer->getSkus(),
            'de_DE',
        );

        foreach ($productsData as $productData) {
            if (!isset($productData[static::ID_PRODUCT_ABSTRACT])) {
                continue;
            }

            $productViewTransfer = $this->productStorageClient
                ->findProductAbstractViewTransfer($productData[static::ID_PRODUCT_ABSTRACT], 'de_DE');

            if ($productViewTransfer === null) {
                continue;
            }

            $discountCalculationRequestTransfer = $this->createDiscountCalculationRequestTransfer(
                $promotionItemTransfer->getDiscount(),
                $productViewTransfer->getPrice(),
            );

            $discountCalculationResponseTransfer = $this->discountService->calculate($discountCalculationRequestTransfer);

            $restPromotionalProductTransfer = $this->promotionProductMapper
                ->mapProductViewTransferToRestPromotionalProductTransfer(
                    $productViewTransfer,
                    $discountCalculationResponseTransfer->getAmount(),
                );

            $restPromotionalItemsAttributesTransfer->addPromotedProduct($restPromotionalProductTransfer);
        }

        return $restPromotionalItemsAttributesTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\DiscountTransfer $discountTransfer
     * @param int $productPrice
     *
     * @return \Generated\Shared\Transfer\DiscountCalculationRequestTransfer
     */
    protected function createDiscountCalculationRequestTransfer(
        DiscountTransfer $discountTransfer,
        int $productPrice
    ): DiscountCalculationRequestTransfer {
        $discountableItemTransfer = (new DiscountableItemTransfer())
            ->setUnitPrice($productPrice);

        return (new DiscountCalculationRequestTransfer())
            ->setDiscountableItems(new ArrayObject($discountableItemTransfer))
            ->setDiscount($discountTransfer);
    }
}
