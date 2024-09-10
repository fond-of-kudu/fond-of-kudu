<?php

namespace FondOfKudu\Client\CustomerMergeGuestOrder;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \FondOfKudu\Client\CustomerMergeGuestOrder\CustomerMergeGuestOrderFactory getFactory()
 */
class CustomerMergeGuestOrderClient extends AbstractClient implements CustomerMergeGuestOrderClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function updateGuestOrder(CustomerTransfer $customerTransfer): void
    {
        $this->getFactory()->createCustomerMergeGuestOrderZedStub()->updateGuestOrder($customerTransfer);
    }
}
