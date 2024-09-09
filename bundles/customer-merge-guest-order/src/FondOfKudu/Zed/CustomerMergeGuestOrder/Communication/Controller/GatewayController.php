<?php

namespace FondOfKudu\Zed\CustomerMergeGuestOrder\Communication\Controller;

use Generated\Shared\Transfer\CustomerMergeGuestOrderResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \FondOfKudu\Zed\CustomerMergeGuestOrder\Business\CustomerMergeGuestOrderFacade getFacade()
 * @method \FondOfKudu\Zed\CustomerMergeGuestOrder\Persistence\CustomerMergeGuestOrderRepositoryInterface getRepository()
 */
class GatewayController extends AbstractGatewayController
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerMergeGuestOrderResponseTransfer
     */
    public function updateGuestOrderAction(CustomerTransfer $customerTransfer): CustomerMergeGuestOrderResponseTransfer
    {
        return $this->getFacade()->updateGuestOrder($customerTransfer);
    }
}
