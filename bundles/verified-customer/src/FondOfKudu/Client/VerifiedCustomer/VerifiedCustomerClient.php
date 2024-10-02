<?php

namespace FondOfKudu\Client\VerifiedCustomer;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\VerifiedCustomerResponseTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \FondOfKudu\Client\VerifiedCustomer\VerifiedCustomerFactory getFactory()
 */
class VerifiedCustomerClient extends AbstractClient implements VerifiedCustomerClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\VerifiedCustomerResponseTransfer
     */
    public function resendAccountVerification(CustomerTransfer $customerTransfer): VerifiedCustomerResponseTransfer
    {
        return $this->getFactory()->createVerifiedCustomerZedStub()->resendAccountVerification($customerTransfer);
    }
}
