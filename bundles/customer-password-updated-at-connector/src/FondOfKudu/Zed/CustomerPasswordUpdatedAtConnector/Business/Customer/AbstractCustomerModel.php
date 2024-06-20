<?php

namespace FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Customer;

use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Orm\Zed\Customer\Persistence\SpyCustomer;
use Spryker\Zed\Customer\Business\Exception\CustomerNotFoundException;

class AbstractCustomerModel
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @throws \Spryker\Zed\Customer\Business\Exception\CustomerNotFoundException
     *
     * @return \Orm\Zed\Customer\Persistence\SpyCustomer
     */
    protected function getCustomer(CustomerTransfer $customerTransfer): SpyCustomer
    {
        $customerEntity = null;

        if ($customerTransfer->getIdCustomer()) {
            $customerEntity = $this->customerQueryContainer->queryCustomerById($customerTransfer->getIdCustomer())
                ->findOne();
        } elseif ($customerTransfer->getEmail()) {
            $customerEntity = $this->customerQueryContainer->queryCustomerByEmail($customerTransfer->getEmail())
                ->findOne();
        } elseif ($customerTransfer->getRestorePasswordKey()) {
            $customerEntity = $this->customerQueryContainer->queryCustomerByRestorePasswordKey($customerTransfer->getRestorePasswordKey())
                ->findOne();
        }

        if ($customerEntity !== null) {
            return $customerEntity;
        }

        throw new CustomerNotFoundException(sprintf(
            'Customer not found by either ID `%s`, email `%s` or restore password key `%s`.',
            $customerTransfer->getIdCustomer(),
            $customerTransfer->getEmail(),
            $customerTransfer->getRestorePasswordKey(),
        ));
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
