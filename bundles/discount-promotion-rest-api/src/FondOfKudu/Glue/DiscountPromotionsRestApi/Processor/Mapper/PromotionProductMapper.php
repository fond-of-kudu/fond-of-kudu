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
     * @param \FondOfKudu\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiConfig $config
     * @param \FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\RestProductPriceAttributeMapperInterface $restProductPriceAttributeMapper
     */
    public function __construct(
        DiscountPromotionsRestApiConfig $config,
        RestProductPriceAttributeMapperInterface $restProductPriceAttributeMapper
    ) {
        $this->config = $config;
        $this->restProductPriceAttributeMapper = $restProductPriceAttributeMapper;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     * @param int $discountAmount
     * @param string $discountPromotionUuid
     *
     * @return \Generated\Shared\Transfer\PromotedProductTransfer
     */
    public function mapProductViewTransferToRestPromotionalProductTransfer(
        ProductViewTransfer $productViewTransfer,
        int $discountAmount,
        string $discountPromotionUuid
    ): PromotedProductTransfer {
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
            ->setImages($this->mapImagesFromStorage($productViewTransfer))
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

    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     *
     * @return array<array>
     */
    protected function mapImagesFromStorage(ProductViewTransfer $productViewTransfer): array
    {
        $images = [];

        /** @var array<\Generated\Shared\Transfer\ProductImageSetStorageTransfer> $productImageStorageTransferCollection */
        foreach ($productViewTransfer->getImageSets() as $index => $productImageStorageTransferCollection) {
            foreach ($productImageStorageTransferCollection as $productImageStorageTransfer) {
                if ($this->config->getImageSetByName() === false) {
                    $images[] = $productImageStorageTransfer->toArray();

                    continue;
                }

                if ($this->config->getImageSetByName() === $index) {
                    return [[$productImageStorageTransfer->toArray()]];
                }
            }
        }

        return $images;
    }
}
