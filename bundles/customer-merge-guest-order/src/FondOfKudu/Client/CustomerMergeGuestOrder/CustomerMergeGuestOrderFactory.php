<?php

namespace FondOfKudu\Client\CustomerMergeGuestOrder;

use FondOfKudu\Client\CustomerMergeGuestOrder\Dependency\Client\CustomerMergeGuestOrderToZedRequestClientInterface;
use FondOfKudu\Client\CustomerMergeGuestOrder\Zed\CustomerMergeGuestOrderZedStub;
use FondOfKudu\Client\CustomerMergeGuestOrder\Zed\CustomerMergeGuestOrderZedStubInterface;
use Spryker\Client\Kernel\AbstractFactory;

class CustomerMergeGuestOrderFactory extends AbstractFactory
{
    /**
     * @return \FondOfKudu\Client\CustomerMergeGuestOrder\Zed\CustomerMergeGuestOrderZedStubInterface
     */
    public function createCustomerMergeGuestOrderZedStub(): CustomerMergeGuestOrderZedStubInterface
    {
        return new CustomerMergeGuestOrderZedStub($this->getZedRequestClient());
    }

    /**
     * @return \FondOfKudu\Client\CustomerMergeGuestOrder\Dependency\Client\CustomerMergeGuestOrderToZedRequestClientInterface
     */
    public function getZedRequestClient(): CustomerMergeGuestOrderToZedRequestClientInterface
    {
        return $this->getProvidedDependency(CustomerMergeGuestOrderDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
