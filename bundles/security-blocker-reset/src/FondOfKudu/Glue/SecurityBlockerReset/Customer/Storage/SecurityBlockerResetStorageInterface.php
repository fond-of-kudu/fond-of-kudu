<?php

namespace FondOfKudu\Glue\SecurityBlockerReset\Customer\Storage;

use Generated\Shared\Transfer\SecurityCheckAuthContextTransfer;

interface SecurityBlockerResetStorageInterface
{
    /**
     * @param \Generated\Shared\Transfer\SecurityCheckAuthContextTransfer $securityCheckAuthContextTransfer
     *
     * @return bool
     */
    public function resetLoginBlock(SecurityCheckAuthContextTransfer $securityCheckAuthContextTransfer): bool;
}
