<?php

namespace FondOfKudu\Zed\CheckoutRestApi\Communication\Plugin;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;
use Spryker\Zed\CheckoutRestApiExtension\Dependency\Plugin\QuoteMapperPluginInterface;

class CartCustomerReferenceQuoteMapperPlugin implements QuoteMapperPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer $restCheckoutRequestAttributesTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function map(RestCheckoutRequestAttributesTransfer $restCheckoutRequestAttributesTransfer, QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        $quoteTransfer->setCartCustomerReference(
            $restCheckoutRequestAttributesTransfer->getCustomer()->getCustomerReference()
        );

        return $quoteTransfer;
    }
}
