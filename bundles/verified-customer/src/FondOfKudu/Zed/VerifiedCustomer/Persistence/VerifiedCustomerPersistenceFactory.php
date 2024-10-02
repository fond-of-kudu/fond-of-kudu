<?php

namespace FondOfKudu\Zed\VerifiedCustomer\Persistence;

use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfKudu\Zed\VerifiedCustomer\Persistence\VerifiedCustomerRepositoryInterface getRepository()
 * @method \FondOfKudu\Zed\VerifiedCustomer\VerifiedCustomerConfig getConfig()
 */
class VerifiedCustomerPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Customer\Persistence\SpyCustomerQuery
     */
    public function createCustomerQuery(): SpyCustomerQuery
    {
        return new SpyCustomerQuery();
    }
}
