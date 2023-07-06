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
        ]);
    }
}
