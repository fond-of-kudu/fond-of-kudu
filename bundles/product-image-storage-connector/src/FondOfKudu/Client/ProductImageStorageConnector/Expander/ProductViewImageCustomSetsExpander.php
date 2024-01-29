<?php

namespace FondOfKudu\Client\ProductImageStorageConnector\Expander;

use ArrayObject;
use FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client\ProductImageStorageConnectorToProductImageStorageClientInterface;
use FondOfKudu\Client\ProductImageStorageConnector\ProductImageStorageConnectorConfig;
use FondOfKudu\Shared\ProductImageStorageConnector\ProductImageStorageConnectorConstants;
use Generated\Shared\Transfer\ProductImageSetStorageTransfer;
use Generated\Shared\Transfer\ProductViewTransfer;

class ProductViewImageCustomSetsExpander implements ProductViewImageCustomSetsExpanderInterface
{
    /**
     * @var \FondOfKudu\Client\ProductImageStorageConnector\ProductImageStorageConnectorConfig
     */
    protected ProductImageStorageConnectorConfig $config;

    /**
     * @var \FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client\ProductImageStorageConnectorToProductImageStorageClientInterface
     */
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
     * @param array<string, mixed> $productData
     * @param string $localeName
     *
     * @return \Generated\Shared\Transfer\ProductViewTransfer
     */
    public function expandProductViewTransfer(
        ProductViewTransfer $productViewTransfer,
        array $productData,
        string $localeName
    ): ProductViewTransfer {
        $imageSetNames = $this->config->getImageSets();
        $images = [];

        if ($this->config->allwaysDefaultImageSet() === true && !in_array(ProductImageStorageConnectorConstants::DEFAULT_IMAGE_SET_NAME, $imageSetNames)) {
            array_push($imageSetNames, ProductImageStorageConnectorConstants::DEFAULT_IMAGE_SET_NAME);
        }

        foreach ($imageSetNames as $imageSetName) {
            $productImageStorageTransfer = $this->getImages(
                $productViewTransfer,
                $localeName,
                $imageSetName,
            );

            if ($productImageStorageTransfer === null) {
                continue;
            }

            $images[strtoupper($imageSetName)] = $productImageStorageTransfer->getImages();
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
     * @return \Generated\Shared\Transfer\ProductImageSetStorageTransfer|null
     */
    protected function getImages(
        ProductViewTransfer $productViewTransfer,
        string $locale,
        string $imageSetName
    ): ?ProductImageSetStorageTransfer {
        $productAbstractImageStorageTransfer = $this->connectorToProductImageStorageClient
            ->findProductImageAbstractStorageTransfer($productViewTransfer->getIdProductAbstract(), $locale);

        if (!$productAbstractImageStorageTransfer) {
            return null;
        }

        return $this->getImageSetImages($productAbstractImageStorageTransfer->getImageSets(), $imageSetName);
    }

    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\ProductImageSetStorageTransfer> $ProductImageSetStorageTransferCollection
     * @param string $imageSetName
     *
     * @return \Generated\Shared\Transfer\ProductImageSetStorageTransfer|null
     */
    protected function getImageSetImages(
        ArrayObject $ProductImageSetStorageTransferCollection,
        string $imageSetName
    ): ?ProductImageSetStorageTransfer {
        foreach ($ProductImageSetStorageTransferCollection as $productImageSetStorageTransfer) {
            if ($productImageSetStorageTransfer->getName() !== $imageSetName) {
                continue;
            }

            return $productImageSetStorageTransfer;
        }

        if ($imageSetName !== ProductImageStorageConnectorConstants::DEFAULT_IMAGE_SET_NAME) {
            return $this->getImageSetImages(
                $ProductImageSetStorageTransferCollection,
                ProductImageStorageConnectorConstants::DEFAULT_IMAGE_SET_NAME,
            );
        }

        return null;
    }
}
