<?php

namespace FondOfKudu\Zed\CheckoutRestApiCountryConnector\Communication\Plugin\CheckoutRestApi;

use Generated\Shared\Transfer\RestCheckoutDataTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;
use Spryker\Zed\CheckoutRestApiExtension\Dependency\Plugin\CheckoutDataExpanderPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business\CheckoutRestApiCountryConnectorFacadeInterface getFacade()
 */
class CountryCheckoutDataExpanderPlugin extends AbstractPlugin implements CheckoutDataExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCheckoutDataTransfer $restCheckoutDataTransfer
     * @param \Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer $restCheckoutRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestCheckoutDataTransfer
     */
    public function expandCheckoutData(
        RestCheckoutDataTransfer $restCheckoutDataTransfer,
        RestCheckoutRequestAttributesTransfer $restCheckoutRequestAttributesTransfer
    ): RestCheckoutDataTransfer {
        return $this->getFacade()->expandCheckoutDataWithCountries(
            $restCheckoutDataTransfer,
            $restCheckoutRequestAttributesTransfer,
        );
    }
}
