<?php

namespace FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business;

use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Checker\PasswordResetExpirationChecker;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Checker\PasswordResetExpirationCheckerInterface;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Customer\CustomerPasswordUpdated;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Customer\CustomerPasswordUpdatedInterface;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Customer\CustomerRestorePassword;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Customer\CustomerRestorePasswordInterface;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\CustomerExpander\CustomerExpander;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\CustomerExpander\CustomerExpanderInterface;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\CustomerPasswordUpdatedAtConnectorDependencyProvider;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\Facade\CustomerPasswordUpdatedAtConnectorMailFacadeInterface;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\QueryContainer\CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\CustomerPasswordUpdatedAtConnectorConfig getConfig()
 */
class CustomerPasswordUpdatedAtConnectorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Customer\CustomerRestorePasswordInterface
     */
    public function createCustomerRestorePassword(): CustomerRestorePasswordInterface
    {
        return new CustomerRestorePassword(
            $this->addCustomerQueryContainer(),
            $this->createPasswordResetExpirationChecker(),
            $this->createCustomerExpander(),
            $this->getMailFacade(),
        );
    }

    /**
     * @return \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Customer\CustomerPasswordUpdatedInterface
     */
    public function createCustomerPasswordUpdated(): CustomerPasswordUpdatedInterface
    {
        return new CustomerPasswordUpdated($this->addCustomerQueryContainer(), $this->getConfig());
    }

    /**
     * @return \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\CustomerExpander\CustomerExpanderInterface
     */
    protected function createCustomerExpander(): CustomerExpanderInterface
    {
        return new CustomerExpander($this->getCustomerTransferExpanderPlugins());
    }

    /**
     * @return \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Checker\PasswordResetExpirationCheckerInterface
     */
    protected function createPasswordResetExpirationChecker(): PasswordResetExpirationCheckerInterface
    {
        return new PasswordResetExpirationChecker($this->getConfig());
    }

    /**
     * @return array<\Spryker\Zed\Customer\Dependency\Plugin\CustomerTransferExpanderPluginInterface>
     */
    protected function getCustomerTransferExpanderPlugins(): array
    {
        return $this->getProvidedDependency(CustomerPasswordUpdatedAtConnectorDependencyProvider::PLUGINS_CUSTOMER_TRANSFER_EXPANDER);
    }

    /**
     * @return \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\Facade\CustomerPasswordUpdatedAtConnectorMailFacadeInterface
     */
    protected function getMailFacade(): CustomerPasswordUpdatedAtConnectorMailFacadeInterface
    {
        return $this->getProvidedDependency(CustomerPasswordUpdatedAtConnectorDependencyProvider::FACADE_MAIL);
    }

    /**
     * @return \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\QueryContainer\CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerInterface
     */
    protected function addCustomerQueryContainer(): CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerInterface
    {
        return $this->getProvidedDependency(CustomerPasswordUpdatedAtConnectorDependencyProvider::QUERY_CONTAINER_CUSTOMER);
    }
}
