<?php

namespace FondOfKudu\Client\SecurityBlockerReset;

use Generated\Shared\Transfer\SecurityCheckAuthContextTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \FondOfKudu\Client\SecurityBlockerReset\SecurityBlockerResetFactory getFactory()
 */
class SecurityBlockerResetClient extends AbstractClient implements SecurityBlockerResetClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\SecurityCheckAuthContextTransfer $securityCheckAuthContextTransfer
     *
     * @return bool
     */
    public function resetLoginBlock(SecurityCheckAuthContextTransfer $securityCheckAuthContextTransfer): bool
    {
        return $this->getFactory()
            ->createSecurityBlockerResetStorageResetter()
            ->resetLoginBlock($securityCheckAuthContextTransfer);
    }
}
