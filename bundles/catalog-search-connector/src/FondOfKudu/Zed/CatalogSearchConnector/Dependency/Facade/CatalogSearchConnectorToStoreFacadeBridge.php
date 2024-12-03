<?php

namespace FondOfKudu\Zed\CatalogSearchConnector\Dependency\Facade;

use Generated\Shared\Transfer\StoreTransfer;
use Spryker\Zed\Store\Business\StoreFacadeInterface;

class CatalogSearchConnectorToStoreFacadeBridge implements CatalogSearchConnectorToStoreFacadeInterface
{
    /**
     * @var \Spryker\Zed\Store\Business\StoreFacadeInterface
     */
    protected StoreFacadeInterface $storeFacade;

    /**
     * @param \Spryker\Zed\Store\Business\StoreFacadeInterface $storeFacade
     */
    public function __construct(StoreFacadeInterface $storeFacade)
    {
        $this->storeFacade = $storeFacade;
    }

    /**
     * @param string $storeName
     *
     * @return \Generated\Shared\Transfer\StoreTransfer|null
     */
    public function findStoreByName(string $storeName): ?StoreTransfer
    {
        return $this->storeFacade->findStoreByName($storeName);
    }
}
