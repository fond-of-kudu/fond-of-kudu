<?php

namespace FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Customer;

use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\CustomerPasswordUpdatedAtConnectorConfig;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\QueryContainer\CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerInterface;
use Generated\Shared\Transfer\CustomerErrorTransfer;
use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Shared\Customer\Code\Messages;
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
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function passwordUpdated(CustomerTransfer $customerTransfer): CustomerResponseTransfer
    {
        $customerResponseTransfer = $this->createCustomerResponseTransfer();

        try {
            $customerEntity = $this->getCustomer($customerTransfer);
        } catch (CustomerNotFoundException $e) {
            $customerError = new CustomerErrorTransfer();
            $customerError->setMessage(Messages::CUSTOMER_TOKEN_INVALID);

            $customerResponseTransfer
                ->setIsSuccess(false)
                ->addError($customerError);

            return $customerResponseTransfer;
        }

        if (!$customerResponseTransfer->getIsSuccess()) {
            return $customerResponseTransfer;
        }

        return $customerResponseTransfer;
    }

    /**
     * @param bool $isSuccess
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    protected function createCustomerResponseTransfer(bool $isSuccess = true): CustomerResponseTransfer
    {
        $customerResponseTransfer = new CustomerResponseTransfer();
        $customerResponseTransfer->setIsSuccess($isSuccess);

        return $customerResponseTransfer;
    }
}
