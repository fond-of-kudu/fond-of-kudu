<?php

namespace FondOfKudu\Zed\CheckoutDataProductCountryFilter\Business;

use Generated\Shared\Transfer\RestCheckoutDataTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfKudu\Zed\CheckoutDataProductCountryFilter\Business\CheckoutDataProductCountryFilterBusinessFactory getFactory()
 */
class CheckoutDataProductCountryFilterFacade extends AbstractFacade implements CheckoutDataProductCountryFilterFacadeInterface
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
        return $this->getFactory()
            ->createCheckoutDataProductCountryFilter()
            ->filter($restCheckoutDataTransfer, $restCheckoutRequestAttributesTransfer);
    }
}
