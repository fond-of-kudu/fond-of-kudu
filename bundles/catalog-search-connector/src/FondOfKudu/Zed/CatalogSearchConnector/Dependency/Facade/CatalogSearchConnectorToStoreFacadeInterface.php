<?php

namespace FondOfKudu\Zed\CatalogSearchConnector\Dependency\Facade;

use Generated\Shared\Transfer\StoreTransfer;

interface CatalogSearchConnectorToStoreFacadeInterface
{
    /**
     * @param string $storeName
     *
     * @return \Generated\Shared\Transfer\StoreTransfer|null
     */
    public function findStoreByName(string $storeName): ?StoreTransfer;
}
