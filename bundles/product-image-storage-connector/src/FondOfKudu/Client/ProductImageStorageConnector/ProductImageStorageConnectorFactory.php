<?php

namespace FondOfKudu\Client\ProductImageStorageConnector;

use FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client\ProductImageStorageConnectorToProductImageStorageClientInterface;
use FondOfKudu\Client\ProductImageStorageConnector\Expander\ProductViewImageCustomSetsExpander;
use FondOfKudu\Client\ProductImageStorageConnector\Expander\ProductViewImageCustomSetsExpanderInterface;
use Spryker\Client\Kernel\AbstractFactory;

/**
 * @method \FondOfKudu\Client\ProductImageStorageConnector\ProductImageStorageConnectorConfig getConfig()
 */
class ProductImageStorageConnectorFactory extends AbstractFactory
{
    /**
     * @return \FondOfKudu\Client\ProductImageStorageConnector\Expander\ProductViewImageCustomSetsExpanderInterface
     */
    public function createProductViewImageCustomSetsExpander(): ProductViewImageCustomSetsExpanderInterface
    {
        return new ProductViewImageCustomSetsExpander(
            $this->getConfig(),
            $this->getProductImageStorageClient(),
        );
    }

    /**
     * @return \FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client\ProductImageStorageConnectorToProductImageStorageClientInterface
     */
    protected function getProductImageStorageClient(): ProductImageStorageConnectorToProductImageStorageClientInterface
    {
        return $this->getProvidedDependency(ProductImageStorageConnectorDependencyProvider::CLIENT_PRODUCT_IMAGE_STORAGE);
    }
}
