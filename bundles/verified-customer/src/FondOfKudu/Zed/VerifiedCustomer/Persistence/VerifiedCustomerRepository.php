<?php

namespace FondOfKudu\Zed\VerifiedCustomer\Persistence;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfKudu\Zed\VerifiedCustomer\Persistence\VerifiedCustomerPersistenceFactory getFactory()
 */
class VerifiedCustomerRepository extends AbstractRepository implements VerifiedCustomerRepositoryInterface
{
    /**
     * @param string $customerReference
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function getCustomerByCustomerReference(string $customerReference): ?CustomerTransfer
    {
        $customerEntity = $this->getFactory()
            ->createCustomerQuery()
            ->findOneByCustomerReference($customerReference);

        if ($customerEntity === null) {
            return null;
        }

        $customerTransfer = new CustomerTransfer();

        return $customerTransfer->fromArray($customerEntity->toArray(), true);
    }
}
