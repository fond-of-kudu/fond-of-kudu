<?php

namespace FondOfKudu\Client\SecurityBlockerReset\Storage\Resetter;

use FondOfKudu\Client\SecurityBlockerReset\Redis\SecurityBlockerResetWrapperInterface;
use Generated\Shared\Transfer\SecurityCheckAuthContextTransfer;

class SecurityBlockerResetStorageResetter implements SecurityBlockerResetStorageResetterInterface
{
    /**
     * @var string
     */
    protected const KEY_PART_SEPARATOR = ':';

    /**
     * @var \FondOfKudu\Client\SecurityBlockerReset\Redis\SecurityBlockerResetWrapperInterface
     */
    protected SecurityBlockerResetWrapperInterface $securityBlockerResetWrapper;

    /**
     * @param \FondOfKudu\Client\SecurityBlockerReset\Redis\SecurityBlockerResetWrapperInterface $securityBlockerResetWrapper
     */
    public function __construct(SecurityBlockerResetWrapperInterface $securityBlockerResetWrapper)
    {
        $this->securityBlockerResetWrapper = $securityBlockerResetWrapper;
    }

    /**
     * @param \Generated\Shared\Transfer\SecurityCheckAuthContextTransfer $securityCheckAuthContextTransfer
     *
     * @return bool
     */
    public function resetLoginBlock(SecurityCheckAuthContextTransfer $securityCheckAuthContextTransfer): bool
    {
        $key = $this->getStorageKey($securityCheckAuthContextTransfer);

        $updated = $this->securityBlockerResetWrapper->del([
            $key,
        ]);

        return (bool)$updated;
    }

    /**
     * @param \Generated\Shared\Transfer\SecurityCheckAuthContextTransfer $securityCheckAuthContextTransfer
     *
     * @return string
     */
    protected function getStorageKey(SecurityCheckAuthContextTransfer $securityCheckAuthContextTransfer): string
    {
        return $securityCheckAuthContextTransfer->getTypeOrFail()
            . static::KEY_PART_SEPARATOR
            . $securityCheckAuthContextTransfer->getIp()
            . static::KEY_PART_SEPARATOR
            . $securityCheckAuthContextTransfer->getAccount();
    }
}
