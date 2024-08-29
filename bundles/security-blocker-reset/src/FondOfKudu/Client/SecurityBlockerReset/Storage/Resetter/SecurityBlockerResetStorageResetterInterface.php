<?php

namespace FondOfKudu\Client\SecurityBlockerReset\Storage\Resetter;

use Generated\Shared\Transfer\SecurityCheckAuthContextTransfer;

interface SecurityBlockerResetStorageResetterInterface
{
    /**
     * @param \Generated\Shared\Transfer\SecurityCheckAuthContextTransfer $securityCheckAuthContextTransfer
     *
     * @return bool
     */
    public function resetLoginBlock(SecurityCheckAuthContextTransfer $securityCheckAuthContextTransfer): bool;
}
