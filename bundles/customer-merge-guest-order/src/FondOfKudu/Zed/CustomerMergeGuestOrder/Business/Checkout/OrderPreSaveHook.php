<?php

namespace FondOfKudu\Zed\CustomerMergeGuestOrder\Business\Checkout;

use FondOfKudu\Zed\CustomerMergeGuestOrder\Persistence\CustomerMergeGuestOrderRepositoryInterface;
use Generated\Shared\Transfer\QuoteTransfer;

class OrderPreSaveHook implements OrderPreSaveHookInterface
{
    /**
     * @var \FondOfKudu\Zed\CustomerMergeGuestOrder\Persistence\CustomerMergeGuestOrderRepositoryInterface
     */
    protected CustomerMergeGuestOrderRepositoryInterface $repository;

    /**
     * @param \FondOfKudu\Zed\CustomerMergeGuestOrder\Persistence\CustomerMergeGuestOrderRepositoryInterface $repository
     */
    public function __construct(CustomerMergeGuestOrderRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function updateCustomerReference(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        $orderCustomer = $quoteTransfer->getCustomer();
        $existingCustomer = $this->repository->getCustomerByEmail($orderCustomer->getEmail());
        if ($existingCustomer === null) {
            return $quoteTransfer;
        }

        $orderCustomer->setCustomerReference($existingCustomer->getCustomerReference());

        return $quoteTransfer;
    }
}
