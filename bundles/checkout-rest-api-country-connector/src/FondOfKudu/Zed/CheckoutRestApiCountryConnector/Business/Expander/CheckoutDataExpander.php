<?php

namespace FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business\Expander;

use FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToCountryFacadeInterface;
use FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToStoreFacadeInterface;
use Generated\Shared\Transfer\RestCheckoutDataTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;

class CheckoutDataExpander implements CheckoutDataExpanderInterface
{
    /**
     * @var \FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToStoreFacadeInterface
     */
    protected $storeFacade;

    /**
     * @var \FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToCountryFacadeInterface
     */
    protected $countryFacade;

    /**
     * @var array<\FondOfKudu\Zed\CheckoutRestApiCountryExtension\Dependency\Plugin\CheckoutRestApiCountryFilterPluginInterface>
     */
    protected $checkoutRestApiCountryFilterPlugins;

    /**
     * @param \FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToStoreFacadeInterface $storeFacade
     * @param \FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToCountryFacadeInterface $countryFacade
     * @param array<\FondOfKudu\Zed\CheckoutRestApiCountryExtension\Dependency\Plugin\CheckoutRestApiCountryFilterPluginInterface> $checkoutRestApiCountryFilterPlugins
     */
    public function __construct(
        CheckoutRestApiCountryConnectorToStoreFacadeInterface $storeFacade,
        CheckoutRestApiCountryConnectorToCountryFacadeInterface $countryFacade,
        array $checkoutRestApiCountryFilterPlugins
    ) {
        $this->storeFacade = $storeFacade;
        $this->countryFacade = $countryFacade;
        $this->checkoutRestApiCountryFilterPlugins = $checkoutRestApiCountryFilterPlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCheckoutDataTransfer $restCheckoutDataTransfer
     * @param \Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer $restCheckoutRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestCheckoutDataTransfer
     */
    public function expandCheckoutDataWithCountries(
        RestCheckoutDataTransfer $restCheckoutDataTransfer,
        RestCheckoutRequestAttributesTransfer $restCheckoutRequestAttributesTransfer
    ): RestCheckoutDataTransfer {
        if (!$restCheckoutDataTransfer->getQuote()) {
            return $restCheckoutDataTransfer;
        }

        $restCheckoutDataTransfer = $this->addCountriesToRestCheckoutData($restCheckoutDataTransfer);

        foreach ($this->checkoutRestApiCountryFilterPlugins as $plugin) {
            $restCheckoutDataTransfer = $plugin->filter(
                $restCheckoutDataTransfer,
                $restCheckoutRequestAttributesTransfer,
            );
        }

        return $restCheckoutDataTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCheckoutDataTransfer $restCheckoutDataTransfer
     *
     * @return \Generated\Shared\Transfer\RestCheckoutDataTransfer
     */
    protected function addCountriesToRestCheckoutData(
        RestCheckoutDataTransfer $restCheckoutDataTransfer
    ): RestCheckoutDataTransfer {
        foreach ($this->storeFacade->getCurrentStore()->getCountries() as $iso2Code) {
            $restCheckoutDataTransfer->addCountry($this->countryFacade->getCountryByIso2Code($iso2Code));
        }

        return $restCheckoutDataTransfer;
    }
}
