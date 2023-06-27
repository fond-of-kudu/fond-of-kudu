<?php

namespace FondOfKudu\Glue\CheckoutRestApiCountryConnector\Plugin\CheckoutRestApi;

use Generated\Shared\Transfer\RestCheckoutDataResponseAttributesTransfer;
use Generated\Shared\Transfer\RestCheckoutDataTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;
use Spryker\Glue\CheckoutRestApiExtension\Dependency\Plugin\CheckoutDataResponseMapperPluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

/**
 * @method \FondOfKudu\Glue\CheckoutRestApiCountryConnector\CheckoutRestApiCountryConnectorFactory getFactory()
 */
class CountryCheckoutDataResponseMapperPlugin extends AbstractPlugin implements CheckoutDataResponseMapperPluginInterface
{
    /**
     * {@inheritDoc}
     * - Maps RestCheckoutDataResponseAttributesTransfer.selectedPaymentMethods.
     * - Uses RestCheckoutRequestAttributesTransfer.payments information to find the payment method in the RestCheckoutDataTransfer.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestCheckoutDataTransfer $restCheckoutDataTransfer
     * @param \Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer $restCheckoutRequestAttributesTransfer
     * @param \Generated\Shared\Transfer\RestCheckoutDataResponseAttributesTransfer $restCheckoutResponseAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestCheckoutDataResponseAttributesTransfer
     */
    public function mapRestCheckoutDataResponseTransferToRestCheckoutDataResponseAttributesTransfer(
        RestCheckoutDataTransfer $restCheckoutDataTransfer,
        RestCheckoutRequestAttributesTransfer $restCheckoutRequestAttributesTransfer,
        RestCheckoutDataResponseAttributesTransfer $restCheckoutResponseAttributesTransfer
    ): RestCheckoutDataResponseAttributesTransfer {
        return $this->getFactory()
            ->createCountryMapper()
            ->mapRestCheckoutDataResponseTransferToRestCheckoutDataResponseAttributesTransfer(
                $restCheckoutDataTransfer,
                $restCheckoutRequestAttributesTransfer,
                $restCheckoutResponseAttributesTransfer,
            );
    }
}
