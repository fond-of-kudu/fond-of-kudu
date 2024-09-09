<?php

namespace FondOfKudu\Glue\CustomerMergeGuestOrder\Processor;

use FondOfKudu\Client\CustomerMergeGuestOrder\CustomerMergeGuestOrderClientInterface;
use Generated\Shared\Transfer\CustomerTransfer;

class OrderUpdater implements OrderUpdaterInterface
{
    /**
     * @var \FondOfKudu\Client\CustomerMergeGuestOrder\CustomerMergeGuestOrderClientInterface
     */
    protected CustomerMergeGuestOrderClientInterface $client;

    /**
     * @param \FondOfKudu\Client\CustomerMergeGuestOrder\CustomerMergeGuestOrderClientInterface $client
     */
    public function __construct(CustomerMergeGuestOrderClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function updateGuestOrder(CustomerTransfer $customerTransfer): void
    {
        $this->client->updateGuestOrder($customerTransfer);
    }
}
