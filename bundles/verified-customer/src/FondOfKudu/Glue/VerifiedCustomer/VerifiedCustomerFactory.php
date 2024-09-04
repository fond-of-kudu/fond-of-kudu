<?php

namespace FondOfKudu\Glue\VerifiedCustomer;

use FondOfKudu\Glue\VerifiedCustomer\Dependency\Client\VerifiedCustomerToCustomerInterface;
use FondOfKudu\Glue\VerifiedCustomer\Processor\Validator\VerifiedCustomerValidator;
use FondOfKudu\Glue\VerifiedCustomer\Processor\Validator\VerifiedCustomerValidatorInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class VerifiedCustomerFactory extends AbstractFactory
{
    /**
     * @return \FondOfKudu\Glue\VerifiedCustomer\Processor\Validator\VerifiedCustomerValidatorInterface
     */
    public function createVerifiedCustomerValidator(): VerifiedCustomerValidatorInterface
    {
        return new VerifiedCustomerValidator(
            $this->getCustomerClient(),
        );
    }

    /**
     * @return \FondOfKudu\Glue\VerifiedCustomer\Dependency\Client\VerifiedCustomerToCustomerInterface
     */
    protected function getCustomerClient(): VerifiedCustomerToCustomerInterface
    {
        return $this->getProvidedDependency(VerifiedCustomerDependencyProvider::CLIENT_CUSTOMER);
    }
}
