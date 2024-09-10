<?php

namespace FondOfKudu\Client\CustomerMergeGuestOrder\Zed;

use Generated\Shared\Transfer\CustomerTransfer;

interface CustomerMergeGuestOrderZedStubInterface
{
 /**
  * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
  *
  * @return void
  */
    public function updateGuestOrder(CustomerTransfer $customerTransfer): void;
}
