<?php

namespace FondOfKudu\Glue\CheckoutRestApiCountryConnector\Processor\Mapper;

use FondOfKudu\Glue\CheckoutRestApiCountryConnector\Dependency\Client\CheckoutRestApiCountryConnectorToGlossaryStorageClientInterface;
use FondOfKudu\Glue\CheckoutRestApiCountryConnector\Dependency\Client\CheckoutRestApiCountryConnectorToLocaleClientInterface;
use Generated\Shared\Transfer\CountryRestCheckoutDataResponseAttributesTransfer;
use Generated\Shared\Transfer\RestCheckoutDataResponseAttributesTransfer;
use Generated\Shared\Transfer\RestCheckoutDataTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;

class CountryMapper implements CountryMapperInterface
{
    /**
     * @var \FondOfKudu\Glue\CheckoutRestApiCountryConnector\Dependency\Client\CheckoutRestApiCountryConnectorToGlossaryStorageClientInterface
     */
    private $glossaryStorageClient;

    /**
     * @var \FondOfKudu\Glue\CheckoutRestApiCountryConnector\Dependency\Client\CheckoutRestApiCountryConnectorToLocaleClientInterface
     */
    private $localeClient;

    /**
     * @param \FondOfKudu\Glue\CheckoutRestApiCountryConnector\Dependency\Client\CheckoutRestApiCountryConnectorToGlossaryStorageClientInterface $glossaryStorageClient
     * @param \FondOfKudu\Glue\CheckoutRestApiCountryConnector\Dependency\Client\CheckoutRestApiCountryConnectorToLocaleClientInterface $localeClient
     */
    public function __construct(
        CheckoutRestApiCountryConnectorToGlossaryStorageClientInterface $glossaryStorageClient,
        CheckoutRestApiCountryConnectorToLocaleClientInterface $localeClient
    ) {
        $this->glossaryStorageClient = $glossaryStorageClient;
        $this->localeClient = $localeClient;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCheckoutDataTransfer $restCheckoutDataTransfer
     * @param \Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer $restCheckoutRequestAttributesTransfer
     * @param \Generated\Shared\Transfer\RestCheckoutDataResponseAttributesTransfer $restCheckoutDataResponseAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestCheckoutDataResponseAttributesTransfer
     */
    public function mapRestCheckoutDataResponseTransferToRestCheckoutDataResponseAttributesTransfer(
        RestCheckoutDataTransfer $restCheckoutDataTransfer,
        RestCheckoutRequestAttributesTransfer $restCheckoutRequestAttributesTransfer,
        RestCheckoutDataResponseAttributesTransfer $restCheckoutDataResponseAttributesTransfer
    ): RestCheckoutDataResponseAttributesTransfer {
        foreach ($restCheckoutDataTransfer->getCountries() as $countryTransfer) {
            $countryTranslationKey = sprintf('countries.iso.%s', strtoupper($countryTransfer->getIso2Code()));

            $countryRestCheckoutDataResponseAttributesTransfer = (new CountryRestCheckoutDataResponseAttributesTransfer())
                ->setIdCountry($countryTransfer->getIdCountry())
                ->setName($this->glossaryStorageClient->translate($countryTranslationKey, $this->localeClient->getCurrentLocale()))
                ->setIso2Code($countryTransfer->getIso2Code());

            $restCheckoutDataResponseAttributesTransfer->addCountry($countryRestCheckoutDataResponseAttributesTransfer);
        }

        return $restCheckoutDataResponseAttributesTransfer;
    }
}
