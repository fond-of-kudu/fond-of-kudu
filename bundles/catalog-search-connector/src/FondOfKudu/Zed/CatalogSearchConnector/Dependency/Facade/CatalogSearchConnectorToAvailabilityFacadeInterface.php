<?php

namespace FondOfKudu\Zed\CatalogSearchConnector\Dependency\Facade;

use Generated\Shared\Transfer\ProductAbstractAvailabilityTransfer;
use Generated\Shared\Transfer\StoreTransfer;

interface CatalogSearchConnectorToAvailabilityFacadeInterface
{
    /**
     * @param string $sku
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractAvailabilityTransfer|null
     */
    public function findOrCreateProductAbstractAvailabilityBySkuForStore(
        string $sku,
        StoreTransfer $storeTransfer
    ): ?ProductAbstractAvailabilityTransfer;
}