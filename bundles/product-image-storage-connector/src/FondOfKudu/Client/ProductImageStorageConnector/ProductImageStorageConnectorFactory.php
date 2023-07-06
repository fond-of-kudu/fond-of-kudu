<?php

namespace FondOfKudu\Client\ProductImageStorageConnector;

use FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client\ProductImageStorageConnectorToProductImageStorageClientInterface;
use FondOfKudu\Client\ProductImageStorageConnector\Expander\ProductViewImageCustomSetsExpander;
use FondOfKudu\Client\ProductImageStorageConnector\Expander\ProductViewImageCustomSetsExpanderInterface;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\ProductImageStorage\Dependency\Service\ProductImageStorageToSynchronizationServiceInterface;
use Spryker\Client\ProductImageStorage\Storage\ProductAbstractImageStorageReader;
use Spryker\Client\ProductImageStorage\Storage\ProductImageStorageKeyGenerator;

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
     * @return \Spryker\Client\ProductImageStorage\Storage\ProductAbstractImageStorageReaderInterface
     */
    public function createProductAbstractImageStorageReader()
    {
        return new ProductAbstractImageStorageReader(
            $this->getStorageClient(),
            $this->createProductImageStorageKeyGenerator(),
        );
    }

    /**
     * @return \Spryker\Client\ProductImageStorage\Dependency\Client\ProductImageStorageToStorageInterface
     */
    public function getStorageClient()
    {
        return $this->getProvidedDependency(ProductImageStorageConnectorDependencyProvider::CLIENT_STORAGE);
    }

    /**
     * @return \Spryker\Client\ProductImageStorage\Storage\ProductImageStorageKeyGeneratorInterface
     */
    public function createProductImageStorageKeyGenerator()
    {
        return new ProductImageStorageKeyGenerator($this->getSynchronizationService());
    }

    /**
     * @return \Spryker\Client\ProductImageStorage\Dependency\Service\ProductImageStorageToSynchronizationServiceInterface
     */
    public function getSynchronizationService(): ProductImageStorageToSynchronizationServiceInterface
    {
        return $this->getProvidedDependency(ProductImageStorageConnectorDependencyProvider::SERVICE_SYNCHRONIZATION);
    }

    /**
     * @return \FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client\ProductImageStorageConnectorToProductImageStorageClientInterface
     */
    public function getProductImageStorageClient(): ProductImageStorageConnectorToProductImageStorageClientInterface
    {
        return $this->getProvidedDependency(ProductImageStorageConnectorDependencyProvider::CLIENT_PRODUCT_IMAGE_STORAGE);
    }
}
