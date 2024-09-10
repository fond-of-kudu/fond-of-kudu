<?php

namespace FondOfKudu\Zed\CustomerMergeGuestOrder\Persistence;

use Generated\Shared\Transfer\CustomerTransfer;
use Orm\Zed\Sales\Persistence\Map\SpySalesOrderTableMap;
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
        $entities = $this->getFactory()
            ->createOrderQuery()
            ->clear()
            ->filterByEmail($customerTransfer->getEmail())
            ->where(SpySalesOrderTableMap::COL_CUSTOMER_REFERENCE . ' LIKE ?', 'anonymous:%')
            ->find();

        if (count($entities) > 0) {
            foreach ($entities as $entity) {
                $entity->setCustomerReference($customerTransfer->getCustomerReference());
                $entity->save();
            }

            return true;
        }

        return false;
    }
}
