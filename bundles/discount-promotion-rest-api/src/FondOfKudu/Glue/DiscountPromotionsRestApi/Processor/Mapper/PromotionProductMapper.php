<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper;

use FondOfKudu\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiConfig;
use FondOfKudu\Shared\DiscountPromotionsRestApi\DiscountPromotionsRestApiConstants;
use Generated\Shared\Transfer\ProductViewTransfer;
use Generated\Shared\Transfer\PromotedProductTransfer;

class PromotionProductMapper implements PromotionProductMapperInterface
{
    /**
     * @var string
     */
    public const PRODUCT_ATTR_BRAND = 'brand';

    /**
     * @var string
     */
    public const PRODUCT_ATTR_MODEL = 'model';

    /**
     * @var string
     */
    public const PRODUCT_ATTR_MODEL_KEY = 'modelKey';

    /**
     * @var string
     */
    public const PRODUCT_ATTR_MODEL_SIZE = 'modelSize';

    /**
     * @var string
     */
    public const PRODUCT_ATTR_STYLE = 'style';

    /**
     * @var string
     */
    public const PRODUCT_ATTR_STYLE_KEY = 'styleKey';

    /**
     * @var string
     */
    public const PRODUCT_ATTR_TYPE = 'type';

    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiConfig
     */
    protected DiscountPromotionsRestApiConfig $config;

    /**
     * @param \FondOfKudu\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiConfig $config
     */
    public function __construct(DiscountPromotionsRestApiConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     * @param int $discountAmount
     * @param string $uuidDiscountPromotion
     *
     * @return \Generated\Shared\Transfer\PromotedProductTransfer
     */
    public function mapProductViewTransferToRestPromotionalProductTransfer(
        ProductViewTransfer $productViewTransfer,
        int $discountAmount,
        string $uuidDiscountPromotion
    ): PromotedProductTransfer {
        $specialPrice = $productViewTransfer->getPrice() - $discountAmount;
        $attributes = $this->mapAttributesFromProductViewTransfer($productViewTransfer);
        $attributes[DiscountPromotionsRestApiConstants::PRODUCT_ATTR_SPECIAL_PRICE] = $specialPrice;

        return (new PromotedProductTransfer())
            ->fromArray($productViewTransfer->toArray(), true)
            ->setAbstractSku('Abstract-' . $productViewTransfer->getSku())
            ->setUuidDiscountPromotion($uuidDiscountPromotion)
            ->setImages($this->mapImagesFromProductViewTransfer($productViewTransfer))
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
     * @return array
     */
    protected function mapImagesFromProductViewTransfer(ProductViewTransfer $productViewTransfer): array
    {
        $images = [];

        foreach ($productViewTransfer->getImageSets() as $collectionName => $imageCollection) {
            /** @var \Generated\Shared\Transfer\ProductImageStorageTransfer $productImageStorageTransfer */
            foreach ($imageCollection as $productImageStorageTransfer) {
                if ($this->config->getImageSetByName() === null) {
                    $images[$collectionName][] = $productImageStorageTransfer->toArray();
                }

                if ($this->config->getImageSetByName() === $collectionName) {
                    return [$collectionName => [$productImageStorageTransfer->toArray()]];
                }
            }
        }

        return $images;
    }
}
