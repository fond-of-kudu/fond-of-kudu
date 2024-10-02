<?php

namespace FondOfKudu\Zed\VerifiedCustomer\Business;

use FondOfKudu\Zed\VerifiedCustomer\Business\Processor\Mailer;
use FondOfKudu\Zed\VerifiedCustomer\Dependency\Facade\VerifiedCustomerToMailInterface;
use FondOfKudu\Zed\VerifiedCustomer\VerifiedCustomerDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfKudu\Zed\VerifiedCustomer\VerifiedCustomerConfig getConfig()
 * @method \FondOfKudu\Zed\VerifiedCustomer\Persistence\VerifiedCustomerRepositoryInterface getRepository()
 */
class VerifiedCustomerBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfKudu\Zed\VerifiedCustomer\Business\Processor\Mailer
     */
    public function createMailer(): Mailer
    {
        return new Mailer(
            $this->getConfig(),
            $this->getRepository(),
            $this->getMailFacade(),
        );
    }

    /**
     * @return \FondOfKudu\Zed\VerifiedCustomer\Dependency\Facade\VerifiedCustomerToMailInterface
     */
    public function getMailFacade(): VerifiedCustomerToMailInterface
    {
        return $this->getProvidedDependency(VerifiedCustomerDependencyProvider::FACADE_MAIL);
    }
}
