<?php

namespace FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client;

use Generated\Shared\Transfer\ProductAbstractImageStorageTransfer;
use Spryker\Client\ProductImageStorage\ProductImageStorageClientInterface;

class ProductImageStorageConnectorToProductImageStorageClientBridge implements ProductImageStorageConnectorToProductImageStorageClientInterface
{
    /**
     * @var \Spryker\Client\ProductImageStorage\ProductImageStorageClientInterface
     */
    protected $imageStorageClient;

    /**
     * @param \Spryker\Client\ProductImageStorage\ProductImageStorageClientInterface $imageStorageClient
     */
    public function __construct(ProductImageStorageClientInterface $imageStorageClient)
    {
        $this->imageStorageClient = $imageStorageClient;
    }

    /**
     * @param int $idProductAbstract
     * @param string $locale
     *
     * @return \Generated\Shared\Transfer\ProductAbstractImageStorageTransfer|null
     */
    public function findProductImageAbstractStorageTransfer(
        int $idProductAbstract,
        string $locale
    ): ?ProductAbstractImageStorageTransfer {
        return $this->imageStorageClient->findProductImageAbstractStorageTransfer($idProductAbstract, $locale);
    }
}
