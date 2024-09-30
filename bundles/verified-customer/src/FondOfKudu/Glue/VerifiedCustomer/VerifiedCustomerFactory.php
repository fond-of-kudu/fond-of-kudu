<?php

namespace FondOfKudu\Glue\VerifiedCustomer;

use FondOfKudu\Glue\VerifiedCustomer\Dependency\Client\VerifiedCustomerToCustomerInterface;
use FondOfKudu\Glue\VerifiedCustomer\Processor\Customer\VerificationSender;
use FondOfKudu\Glue\VerifiedCustomer\Processor\Customer\VerificationSenderInterface;
use FondOfKudu\Glue\VerifiedCustomer\Processor\Validator\VerifiedCustomerValidator;
use FondOfKudu\Glue\VerifiedCustomer\Processor\Validator\VerifiedCustomerValidatorInterface;
use Spryker\Glue\Kernel\AbstractFactory;

/**
 * @method \FondOfKudu\Glue\VerifiedCustomer\VerifiedCustomerConfig getConfig()
 * @method \FondOfKudu\Client\VerifiedCustomer\VerifiedCustomerClient getClient()
 */
class VerifiedCustomerFactory extends AbstractFactory
{
    /**
     * @return \FondOfKudu\Glue\VerifiedCustomer\Processor\Validator\VerifiedCustomerValidatorInterface
     */
    public function createVerifiedCustomerValidator(): VerifiedCustomerValidatorInterface
    {
        return new VerifiedCustomerValidator(
            $this->getConfig(),
            $this->getCustomerClient(),
        );
    }

    /**
     * @return \FondOfKudu\Glue\VerifiedCustomer\Processor\Customer\VerificationSenderInterface
     */
    public function createCustomerVerificactionSender(): VerificationSenderInterface
    {
        return new VerificationSender(
            $this->getResourceBuilder(),
            $this->getClient(),
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
