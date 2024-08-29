<?php

namespace FondOfKudu\Client\SecurityBlockerReset;

use Generated\Shared\Transfer\SecurityCheckAuthContextTransfer;

interface SecurityBlockerResetClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\SecurityCheckAuthContextTransfer $securityCheckAuthContextTransfer
     *
     * @return bool
     */
    public function resetLoginBlock(SecurityCheckAuthContextTransfer $securityCheckAuthContextTransfer): bool;
}
