<?php

namespace FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client;

interface ProductImageStorageConnectorToLocaleClientInterface
{
    /**
     * @return string
     */
    public function getCurrentLocale(): string;
}
