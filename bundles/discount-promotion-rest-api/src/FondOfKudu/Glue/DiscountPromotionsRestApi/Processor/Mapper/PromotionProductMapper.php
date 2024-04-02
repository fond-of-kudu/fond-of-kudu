<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper;

use ArrayObject;
use DateTime;
use Exception;
use FondOfKudu\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiConfig;
use FondOfKudu\Shared\DiscountPromotionsRestApi\DiscountPromotionsRestApiConstants;
use Generated\Shared\Transfer\ProductViewTransfer;
use Generated\Shared\Transfer\PromotedProductTransfer;
use Generated\Shared\Transfer\PromotionItemTransfer;

class PromotionProductMapper implements PromotionProductMapperInterface
{
    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiConfig
     */
    protected DiscountPromotionsRestApiConfig $config;

    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\RestProductPriceAttributeMapperInterface
     */
    protected RestProductPriceAttributeMapperInterface $restProductPriceAttributeMapper;

    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\RestResponseProductImageMapperInterface
     */
    protected RestResponseProductImageMapperInterface $restResponseProductImageMapper;

    /**
     * @param \FondOfKudu\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiConfig $config
     * @param \FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\RestProductPriceAttributeMapperInterface $restProductPriceAttributeMapper
     * @param \FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\RestResponseProductImageMapperInterface $restResponseProductImageMapper
     */
    public function __construct(
        DiscountPromotionsRestApiConfig $config,
        RestProductPriceAttributeMapperInterface $restProductPriceAttributeMapper,
        RestResponseProductImageMapperInterface $restResponseProductImageMapper
    ) {
        $this->config = $config;
        $this->restProductPriceAttributeMapper = $restProductPriceAttributeMapper;
        $this->restResponseProductImageMapper = $restResponseProductImageMapper;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     * @param \Generated\Shared\Transfer\PromotionItemTransfer $promotionItemTransfer
     * @param int $discountAmount
     *
     * @return \Generated\Shared\Transfer\PromotedProductTransfer
     */
    public function mapProductViewTransferToRestPromotionalProductTransfer(
        ProductViewTransfer $productViewTransfer,
        PromotionItemTransfer $promotionItemTransfer,
        int $discountAmount
    ): PromotedProductTransfer {
        $specialPrice = $productViewTransfer->getPrice() - $discountAmount;

        try {
            $specialPriceFrom = (new DateTime($promotionItemTransfer->getDiscount()->getValidFrom()))->format('Y-m-d');
            $specialPriceTo = (new DateTime($promotionItemTransfer->getDiscount()->getValidTo()))->format('Y-m-d');
        } catch (Exception $e) {
            $specialPriceFrom = (new DateTime())->modify('-3 day')->format('Y-m-d');
            $specialPriceTo = (new DateTime())->modify('+3 day')->format('Y-m-d');
        }

        $prices = new ArrayObject([
            $this->restProductPriceAttributeMapper->mapFromProductViewTransfer($productViewTransfer),
        ]);

        $attributes = $this->mapAttributesFromProductViewTransfer($productViewTransfer);
        $attributes[DiscountPromotionsRestApiConstants::PRODUCT_ATTR_SPECIAL_PRICE] = $specialPrice;
        $attributes[DiscountPromotionsRestApiConstants::PRODUCT_ATTR_SPECIAL_PRICE_FROM] = $specialPriceFrom;
        $attributes[DiscountPromotionsRestApiConstants::PRODUCT_ATTR_SPECIAL_PRICE_TO] = $specialPriceTo;

        if (getenv('DISCOUNT_PROMOTION_REST_API_FF_PRODUCT_PRICE')) {
            $sku = $productViewTransfer->getSku();
        } else {
            $sku = 'Abstract-' . $productViewTransfer->getSku();
        }

        return (new PromotedProductTransfer())
            ->fromArray($productViewTransfer->toArray(), true)
            ->setAbstractSku($sku)
            ->setDiscountPromotionUuid($promotionItemTransfer->getUuid())
            ->setImages($this->restResponseProductImageMapper->mapFromProductViewTransfer($productViewTransfer))
            ->setPrices($prices)
            ->setAttributes($attributes);
    }

    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     *
     * @return array
     */
    protected function mapAttributesFromProductViewTransfer(
        ProductViewTransfer $productViewTransfer
    ): array {
        $attributes = [];

        foreach ($this->config->getProductViewTransferAttributesToMap() as $attributeName) {
            if (array_key_exists($attributeName, $productViewTransfer->getAttributes())) {
                $attributes[$attributeName] = $productViewTransfer->getAttributes()[$attributeName];
            }
        }

        return $attributes;
    }
}
