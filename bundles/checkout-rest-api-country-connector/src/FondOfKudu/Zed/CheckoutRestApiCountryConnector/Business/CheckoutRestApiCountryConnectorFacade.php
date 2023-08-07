<?php

namespace FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business;

use Generated\Shared\Transfer\RestCheckoutDataTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business\CheckoutRestApiCountryConnectorBusinessFactory getFactory()
 */
class CheckoutRestApiCountryConnectorFacade extends AbstractFacade implements CheckoutRestApiCountryConnectorFacadeInterface
{
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
        return $this->getFactory()
            ->createCheckoutDataExpander()
            ->expandCheckoutDataWithCountries($restCheckoutDataTransfer, $restCheckoutRequestAttributesTransfer);
    }
}
