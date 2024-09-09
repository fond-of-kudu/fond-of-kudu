<?php

namespace FondOfKudu\Zed\CustomerMergeGuestOrder\Business;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
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
     * @return void
     */
    public function updateGuestOrder(CustomerTransfer $customerTransfer): void
    {
        $this->getFactory()->createOrderUpdater()->updateGuestOrder($customerTransfer);
    }
}
