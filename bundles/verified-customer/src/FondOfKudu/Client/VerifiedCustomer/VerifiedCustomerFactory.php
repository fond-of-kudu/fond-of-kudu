<?php

namespace FondOfKudu\Client\VerifiedCustomer;

use FondOfKudu\Client\VerifiedCustomer\Dependency\Client\VerifiedCustomerToZedRequestClientInterface;
use FondOfKudu\Client\VerifiedCustomer\Zed\VerifiedCustomerZedStub;
use FondOfKudu\Client\VerifiedCustomer\Zed\VerifiedCustomerZedStubInterface;
use Spryker\Client\Kernel\AbstractFactory;

class VerifiedCustomerFactory extends AbstractFactory
{
    /**
     * @return \FondOfKudu\Client\VerifiedCustomer\Zed\VerifiedCustomerZedStubInterface
     */
    public function createVerifiedCustomerZedStub(): VerifiedCustomerZedStubInterface
    {
        return new VerifiedCustomerZedStub($this->getZedRequestClient());
    }

    /**
     * @return \FondOfKudu\Client\VerifiedCustomer\Dependency\Client\VerifiedCustomerToZedRequestClientInterface
     */
    public function getZedRequestClient(): VerifiedCustomerToZedRequestClientInterface
    {
        return $this->getProvidedDependency(VerifiedCustomerDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
