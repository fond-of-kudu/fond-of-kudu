<?php

namespace FondOfKudu\Zed\CustomerMergeGuestOrder\Persistence;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \FondOfKudu\Zed\CustomerMergeGuestOrder\Persistence\CustomerMergeGuestOrderPersistenceFactory getFactory()
 */
class CustomerMergeGuestOrderEntityManager extends AbstractEntityManager implements CustomerMergeGuestOrderEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return bool
     */
    public function updateGuestOrder(CustomerTransfer $customerTransfer): bool
    {
        $updates = $this->getFactory()->createOrderQuery()
            ->clear()
            ->filterByEmail($customerTransfer->getEmail())
            ->update([
                'customer_reference' => $customerTransfer->getCustomerReference(),
            ]);

        if ($updates > 0) {
            return true;
        }

        return false;
    }
}
