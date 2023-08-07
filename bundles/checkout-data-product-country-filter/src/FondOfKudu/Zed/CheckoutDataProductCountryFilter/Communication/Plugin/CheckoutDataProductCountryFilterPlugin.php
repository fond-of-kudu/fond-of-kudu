<?php

namespace FondOfKudu\Zed\CheckoutDataProductCountryFilter\Communication\Plugin;

use FondOfKudu\Zed\CheckoutRestApiCountryExtension\Dependency\Plugin\CheckoutRestApiCountryFilterPluginInterface;
use Generated\Shared\Transfer\RestCheckoutDataTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfKudu\Zed\CheckoutDataProductCountryFilter\Business\CheckoutDataProductCountryFilterFacadeInterface getFacade()
 */
class CheckoutDataProductCountryFilterPlugin extends AbstractPlugin implements CheckoutRestApiCountryFilterPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCheckoutDataTransfer $restCheckoutDataTransfer
     * @param \Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer $restCheckoutRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestCheckoutDataTransfer
     */
    public function filter(
        RestCheckoutDataTransfer $restCheckoutDataTransfer,
        RestCheckoutRequestAttributesTransfer $restCheckoutRequestAttributesTransfer
    ): RestCheckoutDataTransfer {
        return $this->getFacade()->filter($restCheckoutDataTransfer, $restCheckoutRequestAttributesTransfer);
    }
}
