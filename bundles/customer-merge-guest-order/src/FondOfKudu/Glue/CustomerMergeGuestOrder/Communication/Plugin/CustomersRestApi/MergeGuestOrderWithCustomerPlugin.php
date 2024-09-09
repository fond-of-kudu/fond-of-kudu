<?php

namespace FondOfKudu\Glue\CustomerMergeGuestOrder\Communication\Plugin\CustomersRestApi;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Glue\CustomersRestApiExtension\Dependency\Plugin\CustomerPostCreatePluginInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

/**
 * @method \FondOfKudu\Glue\CustomerMergeGuestOrder\CustomerMergeGuestOrderFactory getFactory()
 */
class MergeGuestOrderWithCustomerPlugin implements CustomerPostCreatePluginInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function postCreate(RestRequestInterface $restRequest, CustomerTransfer $customerTransfer): CustomerTransfer
    {
        $this->getFactory()->createOrderUpdater()->updateGuestOrder($customerTransfer);

        return $customerTransfer;
    }
}