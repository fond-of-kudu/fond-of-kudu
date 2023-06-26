<?php

namespace FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade;

use Generated\Shared\Transfer\CountryTransfer;

interface CheckoutRestApiCountryConnectorToCountryFacadeInterface
{
    /**
     * Specification:
     * - Reads country from persistence for provided ISO 2 country code
     *
     * @api
     *
     * @param string $iso2Code
     *
     * @return \Generated\Shared\Transfer\CountryTransfer
     */
    public function getCountryByIso2Code($iso2Code): CountryTransfer;
}
