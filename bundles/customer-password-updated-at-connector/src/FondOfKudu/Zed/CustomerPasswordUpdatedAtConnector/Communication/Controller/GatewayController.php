<?php

namespace FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Communication\Controller;

use Generated\Shared\Transfer\CustomerPasswordUpdatedResponseTransfer;
use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\CustomerPasswordUpdatedAtConnectorFacadeInterface getFacade()
 */
class GatewayController extends AbstractGatewayController
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function restorePasswordAction(CustomerTransfer $customerTransfer): CustomerResponseTransfer
    {
        return $this->getFacade()
            ->restorePassword($customerTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerPasswordUpdatedResponseTransfer
     */
    public function passwordUpdatedAction(CustomerTransfer $customerTransfer): CustomerPasswordUpdatedResponseTransfer
    {
        return $this->getFacade()
            ->passwordUpdated($customerTransfer);
    }
}
