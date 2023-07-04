<?php

namespace FondOfKudu\Client\ProductImageStorageConnector;

use FondOfKudu\Client\ProductImageStorageConnector\Expander\ProductViewImageCustomSetsExpander;
use FondOfKudu\Client\ProductImageStorageConnector\Expander\ProductViewImageCustomSetsExpanderInterface;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\ProductImageStorage\Storage\ProductAbstractImageStorageReader;

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
        return new ProductViewImageCustomSetsExpander($this->getConfig());
    }

    /**
     * @return \Spryker\Client\ProductImageStorage\Storage\ProductAbstractImageStorageReaderInterface
     */
    public function createProductAbstractImageStorageReader()
    {
        return new ProductAbstractImageStorageReader($this->getStorage(), $this->createProductImageStorageKeyGenerator());
    }

    /**
     * @return \Spryker\Client\ProductImageStorage\Dependency\Client\ProductImageStorageToStorageInterface
     */
    public function getStorage()
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
     * @return \Spryker\Client\ProductImageStorage\Dependency\Service\ProductImageStorageToSynchronizationServiceBridge
     */
    public function getSynchronizationService()
    {
        return $this->getProvidedDependency(ProductImageStorageConnectorDependencyProvider::SERVICE_SYNCHRONIZATION);
    }
}
