<?php

namespace FondOfKudu\Zed\CheckoutDataGiftCartPaymentCountryFilter\Business;

use Generated\Shared\Transfer\RestCheckoutDataTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfKudu\Zed\CheckoutDataGiftCartPaymentCountryFilter\Business\CheckoutDataGiftCartPaymentCountryFilterBusinessFactory getFactory()
 */
class CheckoutDataGiftCartPaymentCountryFilterFacade extends AbstractFacade implements CheckoutDataGiftCartPaymentCountryFilterFacadeInterface
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
            ->createCheckoutDataGiftCartPaymentCountryFilter()
            ->filter($restCheckoutDataTransfer, $restCheckoutRequestAttributesTransfer);
    }
}
