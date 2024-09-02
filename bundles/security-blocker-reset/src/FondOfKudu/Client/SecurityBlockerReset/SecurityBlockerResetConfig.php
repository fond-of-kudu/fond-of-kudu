<?php

namespace FondOfKudu\Client\SecurityBlockerReset;

use FondOfKudu\Shared\SecurityBlockerReset\SecurityBlockerResetConstants;
use Generated\Shared\Transfer\RedisConfigurationTransfer;
use Generated\Shared\Transfer\RedisCredentialsTransfer;
use Spryker\Client\Kernel\AbstractBundleConfig;

class SecurityBlockerResetConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    protected const STORAGE_REDIS_CONNECTION_KEY = 'SECURITY_BLOCKER_REDIS';

    /**
     * Specification:
     * - Returns redis connection key used by the module.
     *
     * @api
     *
     * @return string
     */
    public function getRedisConnectionKey(): string
    {
        return static::STORAGE_REDIS_CONNECTION_KEY;
    }

    /**
     * Specification:
     * - Returns redis connection configuration used by the module.
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\RedisConfigurationTransfer
     */
    public function getRedisConnectionConfiguration(): RedisConfigurationTransfer
    {
        return (new RedisConfigurationTransfer())
            ->setDataSourceNames($this->getDataSourceNames())
            ->setConnectionCredentials($this->getConnectionCredentials())
            ->setClientOptions($this->getConnectionOptions());
    }

    /**
     * @return array<string>
     */
    protected function getDataSourceNames(): array
    {
        return $this->get(SecurityBlockerResetConstants::SECURITY_BLOCKER_RESET_REDIS_DATA_SOURCE_NAMES, []);
    }

    /**
     * @return \Generated\Shared\Transfer\RedisCredentialsTransfer
     */
    protected function getConnectionCredentials(): RedisCredentialsTransfer
    {
        return (new RedisCredentialsTransfer())
            ->setScheme($this->getZedSessionScheme())
            ->setHost($this->get(SecurityBlockerResetConstants::SECURITY_BLOCKER_RESET_REDIS_HOST))
            ->setPort($this->get(SecurityBlockerResetConstants::SECURITY_BLOCKER_RESET_REDIS_PORT))
            ->setDatabase($this->get(SecurityBlockerResetConstants::SECURITY_BLOCKER_RESET_REDIS_DATABASE))
            ->setPassword($this->get(SecurityBlockerResetConstants::SECURITY_BLOCKER_RESET_REDIS_PASSWORD, false))
            ->setIsPersistent($this->get(SecurityBlockerResetConstants::SECURITY_BLOCKER_RESET_REDIS_PERSISTENT_CONNECTION, false));
    }

    /**
     * @return array<string, mixed>
     */
    protected function getConnectionOptions(): array
    {
        return $this->get(SecurityBlockerResetConstants::SECURITY_BLOCKER_RESET_REDIS_CONNECTION_OPTIONS, []);
    }

    /**
     * @deprecated Use $this->get(SecurityBlockerConstants::SECURITY_BLOCKER_REDIS_SCHEME) instead. Added for BC reason only.
     *
     * @return string
     */
    protected function getZedSessionScheme(): string
    {
        return $this->get(SecurityBlockerResetConstants::SECURITY_BLOCKER_RESET_REDIS_SCHEME, false) ?:
            $this->get(SecurityBlockerResetConstants::SECURITY_BLOCKER_RESET_REDIS_PROTOCOL);
    }
}
