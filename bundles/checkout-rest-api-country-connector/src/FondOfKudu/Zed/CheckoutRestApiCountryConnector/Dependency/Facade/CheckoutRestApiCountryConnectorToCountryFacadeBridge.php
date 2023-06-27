<?php

namespace FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade;

use Generated\Shared\Transfer\CountryTransfer;
use Spryker\Zed\Country\Business\CountryFacadeInterface;

class CheckoutRestApiCountryConnectorToCountryFacadeBridge implements CheckoutRestApiCountryConnectorToCountryFacadeInterface
{
    private CountryFacadeInterface $countryFacade;

    /**
     * @param \Spryker\Zed\Country\Business\CountryFacadeInterface $countryFacade
     */
    public function __construct(CountryFacadeInterface $countryFacade)
    {
        $this->countryFacade = $countryFacade;
    }

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
    public function getCountryByIso2Code($iso2Code): CountryTransfer
    {
        return $this->countryFacade->getCountryByIso2Code($iso2Code);
    }
}
