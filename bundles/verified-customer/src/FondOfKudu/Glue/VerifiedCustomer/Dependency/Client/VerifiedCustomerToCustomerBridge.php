<?php

namespace FondOfKudu\Glue\VerifiedCustomer\Dependency\Client;

use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Client\Customer\CustomerClientInterface;

class VerifiedCustomerToCustomerBridge implements VerifiedCustomerToCustomerInterface
{
    /**
     * @var \Spryker\Client\Customer\CustomerClientInterface
     */
    protected CustomerClientInterface $customerClient;

    /**
     * @param \Spryker\Client\Customer\CustomerClientInterface $customerClient
     */
    public function __construct(CustomerClientInterface $customerClient)
    {
        $this->customerClient = $customerClient;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function findCustomerByReference(CustomerTransfer $customerTransfer): CustomerResponseTransfer
    {
        return $this->customerClient->findCustomerByReference($customerTransfer);
    }
}
