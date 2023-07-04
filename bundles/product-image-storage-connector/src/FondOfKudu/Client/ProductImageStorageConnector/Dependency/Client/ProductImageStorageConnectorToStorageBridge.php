<?php

namespace FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client;

use Spryker\Client\Storage\StorageClientInterface;

class ProductImageStorageConnectorToStorageBridge implements ProductImageStorageConnectorToStorageInterface
{
    protected StorageClientInterface $storageClient;

    /**
     * @param \Spryker\Client\Storage\StorageClientInterface $storageClient
     */
    public function __construct(StorageClientInterface $storageClient)
    {
        $this->storageClient = $storageClient;
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get(string $key)
    {
        return $this->storageClient->get($key);
    }
}
