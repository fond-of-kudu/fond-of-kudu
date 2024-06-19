<?php

namespace FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\QueryContainer;

use Orm\Zed\Customer\Persistence\SpyCustomerQuery;

interface CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerInterface
{
    /**
     * @param int $id
     *
     * @return \Orm\Zed\Customer\Persistence\SpyCustomerQuery
     */
    public function queryCustomerById(int $id): SpyCustomerQuery;

    /**
     * @param string $email
     *
     * @return \Orm\Zed\Customer\Persistence\SpyCustomerQuery
     */
    public function queryCustomerByEmail(string $email): SpyCustomerQuery;

    /**
     * @param string $token
     *
     * @return \Orm\Zed\Customer\Persistence\SpyCustomerQuery
     */
    public function queryCustomerByRestorePasswordKey(string $token): SpyCustomerQuery;
}
