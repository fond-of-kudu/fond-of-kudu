<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper;

use FondOfKudu\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiConfig;
use Generated\Shared\Transfer\ProductImageStorageTransfer;
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
        return (new PromotedProductTransfer())
            ->setUuidDiscountPromotion($uuidDiscountPromotion)
            ->setAttributes($this->mapProductViewTransferAttributesToPromotedProductTransfer($productViewTransfer));
    }

    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     *
     * @return array
     */
    protected function mapProductViewTransferAttributesToPromotedProductTransfer(
        ProductViewTransfer $productViewTransfer
    ): array {
        $attributes = [];

        foreach ($this->config->getProductViewTransferAttributesToMap() as $attributeName) {
            if (in_array($attributeName, $productViewTransfer->getAttributes())) {
                $attributes[$attributeName] = $productViewTransfer->getAttributes()[$attributeName];
            }
        }

        return $attributes;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     *
     * @return \Generated\Shared\Transfer\ProductImageStorageTransfer|null
     */
    protected function getThumb(ProductViewTransfer $productViewTransfer): ?ProductImageStorageTransfer
    {
        foreach (($productViewTransfer->getImageSets()) as $index => $imageSet) {
            if ($index !== $this->config->getImageSetNameForPromotedProductThumb()) {
                continue;
            }

            foreach ($imageSet as $image) {
                if ($image instanceof ProductImageStorageTransfer) {
                    return $image;
                }
            }
        }

        return null;
    }
}
