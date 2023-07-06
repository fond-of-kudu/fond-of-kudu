<?php

namespace FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client;

interface ProductImageStorageConnectorToStorageClientInterface
{
    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get(string $key);
}
