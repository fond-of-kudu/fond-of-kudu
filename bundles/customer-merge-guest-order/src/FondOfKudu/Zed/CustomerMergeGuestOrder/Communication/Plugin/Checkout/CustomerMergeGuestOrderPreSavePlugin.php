<?php

namespace FondOfKudu\Zed\CustomerMergeGuestOrder\Communication\Plugin\Checkout;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\CheckoutExtension\Dependency\Plugin\CheckoutPreSavePluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfKudu\Zed\CustomerMergeGuestOrder\Business\CustomerMergeGuestOrderFacade getFacade()
 */
class CustomerMergeGuestOrderPreSavePlugin extends AbstractPlugin implements CheckoutPreSavePluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function preSave(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        return $this->getFacade()->updateCustomerReference($quoteTransfer);
    }
}
