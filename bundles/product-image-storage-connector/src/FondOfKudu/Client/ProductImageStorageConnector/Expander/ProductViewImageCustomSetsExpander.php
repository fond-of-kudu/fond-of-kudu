<?php

namespace FondOfKudu\Client\ProductImageStorageConnector\Expander;

use ArrayObject;
use FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client\ProductImageStorageConnectorToProductImageStorageClientInterface;
use FondOfKudu\Client\ProductImageStorageConnector\ProductImageStorageConnectorConfig;
use FondOfKudu\Shared\ProductImageStorageConnector\ProductImageStorageConnectorConstants;
use Generated\Shared\Transfer\ProductImageStorageTransfer;
use Generated\Shared\Transfer\ProductViewTransfer;

class ProductViewImageCustomSetsExpander implements ProductViewImageCustomSetsExpanderInterface
{
    protected ProductImageStorageConnectorConfig $config;

    protected ProductImageStorageConnectorToProductImageStorageClientInterface $connectorToProductImageStorageClient;

    /**
     * @param \FondOfKudu\Client\ProductImageStorageConnector\ProductImageStorageConnectorConfig $config
     * @param \FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client\ProductImageStorageConnectorToProductImageStorageClientInterface $connectorToProductImageStorageClient
     */
    public function __construct(
        ProductImageStorageConnectorConfig $config,
        ProductImageStorageConnectorToProductImageStorageClientInterface $connectorToProductImageStorageClient
    ) {
        $this->config = $config;
        $this->connectorToProductImageStorageClient = $connectorToProductImageStorageClient;
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
     * @return \Generated\Shared\Transfer\ProductImageStorageTransfer|null
     */
    protected function getImages(ProductViewTransfer $productViewTransfer, $locale, $imageSetName)
    {
        $productAbstractImageSetCollection = $this->connectorToProductImageStorageClient
            ->findProductImageAbstractStorageTransfer($productViewTransfer->getIdProductAbstract(), $locale);

        if (!$productAbstractImageSetCollection) {
            return null;
        }

        return $this->getImageSetImages($productAbstractImageSetCollection->getImageSets(), $imageSetName);
    }

    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\ProductImageSetStorageTransfer> $imageSetStorageCollection
     * @param string $imageSetName
     *
     * @return \Generated\Shared\Transfer\ProductImageStorageTransfer|null
     */
    protected function getImageSetImages(
        ArrayObject $imageSetStorageCollection,
        string $imageSetName
    ): ?ProductImageStorageTransfer {
        foreach ($imageSetStorageCollection as $index => $productImageSetStorageTransfer) {
            if ($productImageSetStorageTransfer->getName() !== $imageSetName) {
                continue;
            }

            return $imageSetStorageCollection[$index]->getImages();
        }

        if ($imageSetName !== ProductImageStorageConnectorConstants::DEFAULT_IMAGE_SET_NAME) {
            return $this->getImageSetImages(
                $imageSetStorageCollection,
                ProductImageStorageConnectorConstants::DEFAULT_IMAGE_SET_NAME,
            );
        }

        if (isset($imageSetStorageCollection[0])) {
            return $imageSetStorageCollection[0]->getImages();
        }

        return null;
    }
}
