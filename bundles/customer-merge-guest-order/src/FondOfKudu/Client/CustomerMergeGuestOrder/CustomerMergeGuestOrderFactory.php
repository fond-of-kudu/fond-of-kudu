<?php

namespace FondOfKudu\Client\CustomerMergeGuestOrder;


use FondOfKudu\Client\CustomerMergeGuestOrder\Dependency\Client\CustomerMergeGuestOrderToZedRequestClientInterface;
use Spryker\Client\CartsRestApi\Zed\CustomerMergeGuestOrderZedStub;
use Spryker\Client\CartsRestApi\Zed\CustomerMergeGuestOrderZedStubInterface;
use Spryker\Client\Kernel\AbstractFactory;

class CustomerMergeGuestOrderFactory extends AbstractFactory
{
    /**
     * @return \Spryker\Client\CartsRestApi\Zed\CustomerMergeGuestOrderZedStubInterface
     */
    public function createCartsRestApiZedStub(): CustomerMergeGuestOrderZedStubInterface
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
