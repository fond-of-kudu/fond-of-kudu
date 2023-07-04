<?php

namespace FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client;

interface ProductImageStorageConnectorToStorageInterface
{
    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get(string $key);
}
