<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper;

use ArrayObject;
use FondOfKudu\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiConfig;
use FondOfKudu\Shared\DiscountPromotionsRestApi\DiscountPromotionsRestApiConstants;
use Generated\Shared\Transfer\ProductViewTransfer;
use Generated\Shared\Transfer\PromotedProductTransfer;

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
     * @param int $discountAmount
     * @param string $discountPromotionUuid
     *
     * @return \Generated\Shared\Transfer\PromotedProductTransfer|null
     */
    public function mapProductViewTransferToRestPromotionalProductTransfer(
        ProductViewTransfer $productViewTransfer,
        int $discountAmount,
        string $discountPromotionUuid
    ): ?PromotedProductTransfer {
        if (!$productViewTransfer->getAvailable()) {
            return null;
        }

        $specialPrice = $productViewTransfer->getPrice() - $discountAmount;
        $attributes = $this->mapAttributesFromProductViewTransfer($productViewTransfer);
        $attributes[DiscountPromotionsRestApiConstants::PRODUCT_ATTR_SPECIAL_PRICE] = $specialPrice;
        $prices = new ArrayObject([
            $this->restProductPriceAttributeMapper->mapFromProductViewTransfer($productViewTransfer),
        ]);

        return (new PromotedProductTransfer())
            ->fromArray($productViewTransfer->toArray(), true)
            ->setAbstractSku('Abstract-' . $productViewTransfer->getSku())
            ->setDiscountPromotionUuid($discountPromotionUuid)
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
