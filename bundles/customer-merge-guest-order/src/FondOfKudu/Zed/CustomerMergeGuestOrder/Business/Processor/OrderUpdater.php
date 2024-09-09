<?php

namespace FondOfKudu\Zed\CustomerMergeGuestOrder\Business\Processor;

use FondOfKudu\Zed\CustomerMergeGuestOrder\Persistence\CustomerMergeGuestOrderEntityManagerInterface;
use FondOfKudu\Zed\CustomerMergeGuestOrder\Persistence\CustomerMergeGuestOrderRepositoryInterface;
use Generated\Shared\Transfer\CustomerTransfer;

class OrderUpdater implements OrderUpdaterInterface
{
    /**
     * @var \FondOfKudu\Zed\CustomerMergeGuestOrder\Persistence\CustomerMergeGuestOrderEntityManagerInterface
     */
    protected CustomerMergeGuestOrderEntityManagerInterface $entityManager;

    /**
     * @var \FondOfKudu\Zed\CustomerMergeGuestOrder\Persistence\CustomerMergeGuestOrderRepositoryInterface
     */
    protected CustomerMergeGuestOrderRepositoryInterface $repository;

    /**
     * @param \FondOfKudu\Zed\CustomerMergeGuestOrder\Persistence\CustomerMergeGuestOrderEntityManagerInterface $entityManager
     */
    public function __construct(
        CustomerMergeGuestOrderRepositoryInterface $repository,
        CustomerMergeGuestOrderEntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function updateGuestOrder(CustomerTransfer $customerTransfer): void
    {
        if ($customerTransfer->getEmail() === null) {
            $customerTransfer = $this->repository->getCustomerByCustomerReference($customerTransfer->getCustomerReference());
        }

        $success = $this->entityManager->updateGuestOrder($customerTransfer);
    }
}
