<?php

namespace FondOfKudu\Glue\SecurityBlockerReset\Customer\Storage;

use FondOfKudu\Client\SecurityBlockerReset\SecurityBlockerResetClientInterface;
use Generated\Shared\Transfer\SecurityCheckAuthContextTransfer;

class SecurityBlockerResetStorage implements SecurityBlockerResetStorageInterface
{
    /**
     * @var \FondOfKudu\Client\SecurityBlockerReset\SecurityBlockerResetClientInterface
     */
    protected SecurityBlockerResetClientInterface $securityBlockerClient;

    /**
     * @param \FondOfKudu\Client\SecurityBlockerReset\SecurityBlockerResetClientInterface $securityBlockerClient
     */
    public function __construct(SecurityBlockerResetClientInterface $securityBlockerClient)
    {
        $this->securityBlockerClient = $securityBlockerClient;
    }

    /**
     * @param \Generated\Shared\Transfer\SecurityCheckAuthContextTransfer $securityCheckAuthContextTransfer
     *
     * @return bool
     */
    public function resetLoginBlock(SecurityCheckAuthContextTransfer $securityCheckAuthContextTransfer): bool
    {
        return $this->securityBlockerClient->resetLoginBlock($securityCheckAuthContextTransfer);
    }
}
