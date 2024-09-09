<?php

namespace FondOfKudu\Zed\CustomerMergeGuestOrder\Business\Processor;

use FondOfKudu\Zed\CustomerMergeGuestOrder\Persistence\CustomerMergeGuestOrderEntityManagerInterface;
use Generated\Shared\Transfer\CustomerTransfer;

class OrderUpdater implements OrderUpdaterInterface
{
    /**
     * @var \FondOfKudu\Zed\CustomerMergeGuestOrder\Persistence\CustomerMergeGuestOrderEntityManagerInterface
     */
    protected CustomerMergeGuestOrderEntityManagerInterface $entityManager;

    /**
     * @param \FondOfKudu\Zed\CustomerMergeGuestOrder\Persistence\CustomerMergeGuestOrderEntityManagerInterface $entityManager
     */
    public function __construct(CustomerMergeGuestOrderEntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function updateGuestOrder(CustomerTransfer $customerTransfer): void
    {
        $success = $this->entityManager->updateGuestOrder($customerTransfer);
    }
}
