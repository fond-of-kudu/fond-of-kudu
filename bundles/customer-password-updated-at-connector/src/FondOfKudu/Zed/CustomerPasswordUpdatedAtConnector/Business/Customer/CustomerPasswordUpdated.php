<?php

namespace FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Customer;

use FondOfKudu\Shared\CustomerPasswordUpdatedAtConnector\Code\Messages;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\CustomerPasswordUpdatedAtConnectorConfig;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\QueryContainer\CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerInterface;
use Generated\Shared\Transfer\CustomerErrorTransfer;
use Generated\Shared\Transfer\CustomerPasswordUpdatedResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Propel\Runtime\Exception\PropelException;
use Spryker\Zed\Customer\Business\Exception\CustomerNotFoundException;

class CustomerPasswordUpdated extends AbstractCustomerModel implements CustomerPasswordUpdatedInterface
{
    /**
     * @var \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\QueryContainer\CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerInterface
     */
    protected CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerInterface $customerQueryContainer;

    /**
     * @var \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\CustomerPasswordUpdatedAtConnectorConfig
     */
    protected CustomerPasswordUpdatedAtConnectorConfig $config;

    /**
     * @param \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\QueryContainer\CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerInterface $customerQueryContainer
     * @param \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\CustomerPasswordUpdatedAtConnectorConfig $config
     */
    public function __construct(
        CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerInterface $customerQueryContainer,
        CustomerPasswordUpdatedAtConnectorConfig $config
    ) {
        $this->customerQueryContainer = $customerQueryContainer;
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerPasswordUpdatedResponseTransfer
     */
    public function passwordUpdated(CustomerTransfer $customerTransfer): CustomerPasswordUpdatedResponseTransfer
    {
        $customerPasswordUpdatedResponseTransfer = $this->createCustomerPasswordUpdatedResponseTransfer();

        try {
            $customerEntity = $this->getCustomer($customerTransfer);
        } catch (CustomerNotFoundException $e) {
            $customerError = new CustomerErrorTransfer();
            $customerError->setMessage(Messages::CUSTOMER_NOT_FOUND);

            $customerPasswordUpdatedResponseTransfer
                ->setIsSuccess(false)
                ->addError($customerError);

            return $customerPasswordUpdatedResponseTransfer;
        }

        if (!$customerPasswordUpdatedResponseTransfer->getIsSuccess()) {
            return $customerPasswordUpdatedResponseTransfer;
        }

        try {
            $isPasswordUpdated = $customerEntity->getPasswordUpdatedAt() >= $this->config->getCustomerUpdateLimit();
            $passwordUpdatedAt = $customerEntity->getPasswordUpdatedAt() === null ? null : $customerEntity->getPasswordUpdatedAt()->format('Y-m-d H:i:s');
            $customerPasswordUpdatedResponseTransfer->setIsUpdated($isPasswordUpdated);
            $customerPasswordUpdatedResponseTransfer->setUpdatedAt($passwordUpdatedAt);
        } catch (PropelException $propelException) {
            $customerError = new CustomerErrorTransfer();
            $customerError->setMessage($propelException->getMessage());

            return $customerPasswordUpdatedResponseTransfer
                ->setIsSuccess(false)
                ->addError($customerError);
        }

        return $customerPasswordUpdatedResponseTransfer;
    }

    /**
     * @param bool $isSuccess
     *
     * @return \Generated\Shared\Transfer\CustomerPasswordUpdatedResponseTransfer
     */
    protected function createCustomerPasswordUpdatedResponseTransfer(bool $isSuccess = true): CustomerPasswordUpdatedResponseTransfer
    {
        $customerPasswordUpdatedResponseTransfer = new CustomerPasswordUpdatedResponseTransfer();
        $customerPasswordUpdatedResponseTransfer->setIsSuccess($isSuccess);

        return $customerPasswordUpdatedResponseTransfer;
    }
}
