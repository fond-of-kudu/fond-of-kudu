<?php

namespace FondOfKudu\Client\ProductImageStorageConnector\Expander;

use FondOfKudu\Client\ProductImageStorageConnector\ProductImageStorageConnectorConfig;
use FondOfKudu\Shared\ProductImageStorageConnector\ProductImageStorageConnectorConstants;
use Generated\Shared\Transfer\ProductViewTransfer;

class ProductViewImageCustomSetsExpander implements ProductViewImageCustomSetsExpanderInterface
{
    protected ProductImageStorageConnectorConfig $config;

    /**
     * @param \FondOfKudu\Client\ProductImageStorageConnector\ProductImageStorageConnectorConfig $config
     */
    public function __construct(ProductImageStorageConnectorConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     * @param string $locale
     * @param string $imageSetName
     *
     * @return \Generated\Shared\Transfer\ProductViewTransfer
     */
    public function expandProductViewImageData(
        ProductViewTransfer $productViewTransfer,
        string $locale,
        string $imageSetName
    ): ProductViewTransfer {
        $imageSetNamesArray = $this->config->getImageSets();
        $images = [];

        if ($this->config->allwaysDefaultImageSet() === true && !in_array(ProductImageStorageConnectorConstants::DEFAULT_IMAGE_SET_NAME, $imageSetNamesArray)) {
            array_push($imageSetNamesArray, ProductImageStorageConnectorConstants::DEFAULT_IMAGE_SET_NAME);
        }

        foreach ($imageSetNamesArray as $imageSetName) {
            $images[strtoupper($imageSetName)] = $this->getImages($productViewTransfer, $locale, $imageSetName);
        }

        if (count($images) > 0) {
            $productViewTransfer->setImageSets($images);
        }

        return $productViewTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     * @param string $locale
     * @param string $imageSetName
     *
     * @return \Generated\Shared\Transfer\ProductImageStorageTransfer[]|null
     */
    protected function getImages(ProductViewTransfer $productViewTransfer, $locale, $imageSetName)
    {
        $productAbstractImageSetCollection = $this->productAbstractImageSetReader
            ->findProductImageAbstractStorageTransfer($productViewTransfer->getIdProductAbstract(), $locale);

        if (!$productAbstractImageSetCollection) {
            return null;
        }

        return $this->getImageSetImages($productAbstractImageSetCollection->getImageSets(), $imageSetName);
    }
}
