<?php

namespace FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client;

use Generated\Shared\Transfer\ProductAbstractImageStorageTransfer;

interface ProductImageStorageConnectorToProductImageStorageClientInterface
{
    /**
     * @param int $idProductAbstract
     * @param string $locale
     *
     * @return \Generated\Shared\Transfer\ProductAbstractImageStorageTransfer|null
     */
    public function findProductImageAbstractStorageTransfer(
        int $idProductAbstract,
        string $locale
    ): ?ProductAbstractImageStorageTransfer;
}
