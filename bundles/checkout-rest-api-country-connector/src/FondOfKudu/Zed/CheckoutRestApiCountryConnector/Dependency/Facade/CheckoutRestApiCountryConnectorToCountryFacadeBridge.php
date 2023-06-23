<?php

namespace FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade;

use Generated\Shared\Transfer\CountryCollectionTransfer;
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
     * @return \Generated\Shared\Transfer\CountryCollectionTransfer
     */
    public function getAvailableCountries(): CountryCollectionTransfer
    {
        return $this->countryFacade->getAvailableCountries();
    }
}
