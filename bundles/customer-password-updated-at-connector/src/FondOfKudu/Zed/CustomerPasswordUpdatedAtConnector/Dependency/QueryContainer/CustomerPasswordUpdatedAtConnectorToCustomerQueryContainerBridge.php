<?php

namespace FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\QueryContainer;

use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Spryker\Zed\Customer\Persistence\CustomerQueryContainerInterface;

class CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerBridge implements CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerInterface
{
    /**
     * @var \Spryker\Zed\Customer\Persistence\CustomerQueryContainerInterface
     */
    protected CustomerQueryContainerInterface $customerQueryContainer;

    /**
     * @param \Spryker\Zed\Customer\Persistence\CustomerQueryContainerInterface $customerQueryContainer
     */
    public function __construct(CustomerQueryContainerInterface $customerQueryContainer)
    {
        $this->customerQueryContainer = $customerQueryContainer;
    }

    /**
     * @param int $id
     *
     * @return \Orm\Zed\Customer\Persistence\SpyCustomerQuery
     */
    public function queryCustomerById(int $id): SpyCustomerQuery
    {
        return $this->customerQueryContainer->queryCustomerById($id);
    }

    /**
     * @param string $email
     *
     * @return \Orm\Zed\Customer\Persistence\SpyCustomerQuery
     */
    public function queryCustomerByEmail(string $email): SpyCustomerQuery
    {
        return $this->customerQueryContainer->queryCustomerByEmail($email);
    }

    /**
     * @param string $token
     *
     * @return \Orm\Zed\Customer\Persistence\SpyCustomerQuery
     */
    public function queryCustomerByRestorePasswordKey(string $token): SpyCustomerQuery
    {
        return $this->customerQueryContainer->queryCustomerByRestorePasswordKey($token);
    }
}
