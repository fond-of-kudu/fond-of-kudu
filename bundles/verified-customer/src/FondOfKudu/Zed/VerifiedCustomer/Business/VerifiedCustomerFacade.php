<?php

namespace FondOfKudu\Zed\VerifiedCustomer\Business;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\VerifiedCustomerResponseTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfKudu\Zed\VerifiedCustomer\Business\VerifiedCustomerBusinessFactory getFactory()
 * @method \FondOfKudu\Zed\VerifiedCustomer\Persistence\VerifiedCustomerRepositoryInterface getRepository()
 */
class VerifiedCustomerFacade extends AbstractFacade
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\VerifiedCustomerResponseTransfer
     */
    public function resendAccountVerification(CustomerTransfer $customerTransfer): VerifiedCustomerResponseTransfer
    {
        return $this->getFactory()->createMailer()->resendAccountVerification($customerTransfer);
    }
}
