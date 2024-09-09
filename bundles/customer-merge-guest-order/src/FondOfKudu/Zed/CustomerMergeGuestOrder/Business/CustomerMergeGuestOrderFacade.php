<?php

namespace FondOfKudu\Zed\CustomerMergeGuestOrder\Business;

use Generated\Shared\Transfer\CustomerMergeGuestOrderResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfKudu\Zed\CustomerMergeGuestOrder\Business\CustomerMergeGuestOrderBusinessFactory getFactory()
 * @method \FondOfKudu\Zed\CustomerMergeGuestOrder\Persistence\CustomerMergeGuestOrderEntityManagerInterface getEntityManager()
 * @method \FondOfKudu\Zed\CustomerMergeGuestOrder\Persistence\CustomerMergeGuestOrderRepositoryInterface getRepository()
 */
class CustomerMergeGuestOrderFacade extends AbstractFacade
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerMergeGuestOrderResponseTransfer
     */
    public function updateGuestOrder(CustomerTransfer $customerTransfer): CustomerMergeGuestOrderResponseTransfer
    {
        return $this->getFactory()->createOrderUpdater()->updateGuestOrder($customerTransfer);
    }
}
