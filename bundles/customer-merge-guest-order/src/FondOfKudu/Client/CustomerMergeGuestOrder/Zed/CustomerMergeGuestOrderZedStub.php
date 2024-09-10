<?php

namespace FondOfKudu\Client\CustomerMergeGuestOrder\Zed;

use FondOfKudu\Client\CustomerMergeGuestOrder\Dependency\Client\CustomerMergeGuestOrderToZedRequestClientInterface;
use Generated\Shared\Transfer\CustomerTransfer;

class CustomerMergeGuestOrderZedStub implements CustomerMergeGuestOrderZedStubInterface
{
    /**
     * @var \FondOfKudu\Client\CustomerMergeGuestOrder\Dependency\Client\CustomerMergeGuestOrderToZedRequestClientInterface
     */
    protected CustomerMergeGuestOrderToZedRequestClientInterface $zedRequestClient;

    /**
     * @param \FondOfKudu\Client\CustomerMergeGuestOrder\Dependency\Client\CustomerMergeGuestOrderToZedRequestClientInterface $zedRequestClient
     */
    public function __construct(CustomerMergeGuestOrderToZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function updateGuestOrder(CustomerTransfer $customerTransfer): void
    {
        $this->zedRequestClient->call('/customer-merge-guest-order/gateway/update-guest-order', $customerTransfer);
    }
}
