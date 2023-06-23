<?php

namespace FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade;

use Generated\Shared\Transfer\CountryCollectionTransfer;

interface CheckoutRestApiCountryConnectorToCountryFacadeInterface
{
    /**
     * @return \Generated\Shared\Transfer\CountryCollectionTransfer
     */
    public function getAvailableCountries(): CountryCollectionTransfer;
}
