<?php

namespace FondOfKudu\Zed\CustomerMergeGuestOrder\Persistence;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfKudu\Zed\CustomerMergeGuestOrder\Persistence\CustomerMergeGuestOrderPersistenceFactory getFactory()
 */
class CustomerMergeGuestOrderRepository extends AbstractRepository implements CustomerMergeGuestOrderRepositoryInterface
{
    /**
     * @param string $email
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function getCustomerByEmail(string $email): ?CustomerTransfer
    {
        $customerEntity = $this->getFactory()
            ->createCustomerQuery()
            ->findOneByEmail($email);

        if ($customerEntity === null) {
            return null;
        }

        $customerTransfer = new CustomerTransfer();

        return $customerTransfer->fromArray($customerEntity->toArray(), true);
    }
}