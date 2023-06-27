<?php

namespace FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade;

use Generated\Shared\Transfer\StoreTransfer;
use Spryker\Zed\Store\Business\StoreFacadeInterface;

class CheckoutRestApiCountryConnectorToStoreFacadeBridge implements CheckoutRestApiCountryConnectorToStoreFacadeInterface
{
    private StoreFacadeInterface $storeFacade;

    /**
     * @param \Spryker\Zed\Store\Business\StoreFacadeInterface $storeFacade
     */
    public function __construct(StoreFacadeInterface $storeFacade)
    {
        $this->storeFacade = $storeFacade;
    }

    /**
     * @return \Generated\Shared\Transfer\StoreTransfer
     */
    public function getCurrentStore(): StoreTransfer
    {
        return $this->storeFacade->getCurrentStore();
    }
}
