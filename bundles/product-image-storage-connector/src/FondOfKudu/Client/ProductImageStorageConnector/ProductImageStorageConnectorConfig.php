<?php

namespace FondOfKudu\Client\ProductImageStorageConnector;

use FondOfKudu\Shared\ProductImageStorageConnector\ProductImageStorageConnectorConstants;
use Spryker\Client\Kernel\AbstractBundleConfig;

class ProductImageStorageConnectorConfig extends AbstractBundleConfig
{
    /**
     * @return bool
     */
    public function allwaysDefaultImageSet(): bool
    {
        return $this->get(ProductImageStorageConnectorConstants::ALWAYS_ADD_DEFAULT_IMAGE_SET, false);
    }

    /**
     * @return array
     */
    public function getImageSets(): array
    {
        return $this->get(ProductImageStorageConnectorConstants::IMAGES_SET_TO_ADD, [
            ProductImageStorageConnectorConstants::IMAGE_SET_ADDITIONAL,
            ProductImageStorageConnectorConstants::IMAGE_SET_THUMBNAIL,
            ProductImageStorageConnectorConstants::IMAGE_SET_BASEIMAGE,
            ProductImageStorageConnectorConstants::IMAGE_SET_HOVERIMAGE,
            ProductImageStorageConnectorConstants::IMAGE_SET_SETIMAGE,
            ProductImageStorageConnectorConstants::IMAGE_SET_FRONT,
            ProductImageStorageConnectorConstants::IMAGE_SET_LEFT,
            ProductImageStorageConnectorConstants::IMAGE_SET_FRONT_LEFT,
            ProductImageStorageConnectorConstants::IMAGE_SET_RIGHT,
            ProductImageStorageConnectorConstants::IMAGE_SET_FRONT_RIGHT,
            ProductImageStorageConnectorConstants::IMAGE_SET_BACK,
            ProductImageStorageConnectorConstants::IMAGE_SET_BACK_LEFT,
            ProductImageStorageConnectorConstants::IMAGE_SET_BACK_RIGHT,
            ProductImageStorageConnectorConstants::IMAGE_SET_TOP,
            ProductImageStorageConnectorConstants::IMAGE_SET_SET_COMPOSING,
            ProductImageStorageConnectorConstants::IMAGE_SET_DETAIL_01,
            ProductImageStorageConnectorConstants::IMAGE_SET_DETAIL_02,
            ProductImageStorageConnectorConstants::IMAGE_SET_DETAIL_03,
            ProductImageStorageConnectorConstants::IMAGE_SET_DETAIL_04,
            ProductImageStorageConnectorConstants::IMAGE_SET_DETAIL_05,
            ProductImageStorageConnectorConstants::IMAGE_SET_DETAIL_06,
            ProductImageStorageConnectorConstants::IMAGE_SET_DETAIL_07,
            ProductImageStorageConnectorConstants::IMAGE_SET_DETAIL_08,
            ProductImageStorageConnectorConstants::IMAGE_SET_DETAIL_09,
            ProductImageStorageConnectorConstants::IMAGE_SET_DETAIL_10,
            ProductImageStorageConnectorConstants::IMAGE_SET_MODEL_01,
            ProductImageStorageConnectorConstants::IMAGE_SET_MODEL_02,
            ProductImageStorageConnectorConstants::IMAGE_SET_MODEL_03,
            ProductImageStorageConnectorConstants::IMAGE_SET_MODEL_04,
            ProductImageStorageConnectorConstants::IMAGE_SET_MODEL_05,
            ProductImageStorageConnectorConstants::IMAGE_SET_MODEL_06,
            ProductImageStorageConnectorConstants::IMAGE_SET_MODEL_07,
            ProductImageStorageConnectorConstants::IMAGE_SET_MODEL_08,
            ProductImageStorageConnectorConstants::IMAGE_SET_MODEL_09,
            ProductImageStorageConnectorConstants::IMAGE_SET_MODEL_13,
            ProductImageStorageConnectorConstants::IMAGE_SET_SOLE,
            ProductImageStorageConnectorConstants::IMAGE_SET_LEFT_INSIDE,
            ProductImageStorageConnectorConstants::IMAGE_SET_RIGHT_INSIDE,
            ProductImageStorageConnectorConstants::IMAGE_SET_LEFT_OUTSIDE,
            ProductImageStorageConnectorConstants::IMAGE_SET_RIGHT_OUTSIDE,
            ProductImageStorageConnectorConstants::IMAGE_SET_USP_01,
            ProductImageStorageConnectorConstants::IMAGE_SET_USP_02,
            ProductImageStorageConnectorConstants::IMAGE_SET_USP_03,
            ProductImageStorageConnectorConstants::IMAGE_SET_SIZE_CHART,
        ]);
    }
}
