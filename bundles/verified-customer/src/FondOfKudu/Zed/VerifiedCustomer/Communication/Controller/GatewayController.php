<?php

namespace FondOfKudu\Zed\VerifiedCustomer\Communication\Controller;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\VerifiedCustomerResponseTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \FondOfKudu\Zed\VerifiedCustomer\Business\VerifiedCustomerFacade getFacade()
 * @method \FondOfKudu\Zed\VerifiedCustomer\Persistence\VerifiedCustomerRepositoryInterface getRepository()
 */
class GatewayController extends AbstractGatewayController
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\VerifiedCustomerResponseTransfer
     */
    public function resendAccountVerificationAction(CustomerTransfer $customerTransfer): VerifiedCustomerResponseTransfer
    {
        return $this->getFacade()->resendAccountVerification($customerTransfer);
    }
}
