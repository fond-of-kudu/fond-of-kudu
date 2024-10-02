<?php

namespace FondOfKudu\Client\VerifiedCustomer\Zed;

use FondOfKudu\Client\VerifiedCustomer\Dependency\Client\VerifiedCustomerToZedRequestClientInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\VerifiedCustomerResponseTransfer;

class VerifiedCustomerZedStub implements VerifiedCustomerZedStubInterface
{
    /**
     * @var \FondOfKudu\Client\VerifiedCustomer\Dependency\Client\VerifiedCustomerToZedRequestClientInterface
     */
    protected VerifiedCustomerToZedRequestClientInterface $zedRequestClient;

    /**
     * @param \FondOfKudu\Client\VerifiedCustomer\Dependency\Client\VerifiedCustomerToZedRequestClientInterface $zedRequestClient
     */
    public function __construct(VerifiedCustomerToZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\VerifiedCustomerResponseTransfer
     */
    public function resendAccountVerification(CustomerTransfer $customerTransfer): VerifiedCustomerResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\VerifiedCustomerResponseTransfer $response */
        $response = $this->zedRequestClient->call('/verified-customer/gateway/resend-account-verification', $customerTransfer);

        return $response;
    }
}
