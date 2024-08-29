<?php

namespace FondOfKudu\Shared\SecurityBlockerReset;

interface SecurityBlockerResetConstants
{
    /**
     * Specification:
     * - Defines a protocol for Redis connection.
     *
     * @api
     *
     * @deprecated Use {@link \FondOfKudu\Shared\SecurityBlockerReset\SecurityBlockerResetConstants::SECURITY_BLOCKER_RESET_REDIS_SCHEME} instead.
     *
     * @var string
     */
    public const SECURITY_BLOCKER_RESET_REDIS_PROTOCOL = 'SECURITY_BLOCKER_REDIS:SECURITY_BLOCKER_REDIS_PROTOCOL';


    /**
     * Specification:
     * - Defines a scheme|protocol (tcp:// or redis://) for Redis connection.
     *
     * @api
     *
     * @var string
     */
    public const SECURITY_BLOCKER_RESET_REDIS_SCHEME = 'SECURITY_BLOCKER_RESET_REDIS:SECURITY_BLOCKER_RESET_REDIS_SCHEME';

    /**
     * Specification:
     * - Defines a host for Redis connection.
     *
     * @api
     *
     * @var string
     */
    public const SECURITY_BLOCKER_RESET_REDIS_HOST = 'SECURITY_BLOCKER_RESET_REDIS:SECURITY_BLOCKER_RESET_REDIS_HOST';

    /**
     * Specification:
     * - Defines a port for Redis connection.
     *
     * @api
     *
     * @var string
     */
    public const SECURITY_BLOCKER_RESET_REDIS_PORT = 'SECURITY_BLOCKER_RESET_REDIS:SECURITY_BLOCKER_RESET_REDIS_PORT';

    /**
     * Specification:
     * - Defines a Redis database to connect to.
     *
     * @api
     *
     * @var string
     */
    public const SECURITY_BLOCKER_RESET_REDIS_DATABASE = 'SECURITY_BLOCKER_RESET_REDIS:SECURITY_BLOCKER_RESET_REDIS_DATABASE';

    /**
     * Specification:
     * - Defines a password for connecting to Redis.
     *
     * @api
     *
     * @var string
     */
    public const SECURITY_BLOCKER_RESET_REDIS_PASSWORD = 'SECURITY_BLOCKER_RESET_REDIS:SECURITY_BLOCKER_RESET_REDIS_PASSWORD';

    /**
     * Specification:
     * - Specifies an array of DSN strings for a multi-instance cluster/replication Redis setup.
     *
     * @api
     *
     * @var string
     */
    public const SECURITY_BLOCKER_RESET_REDIS_DATA_SOURCE_NAMES = 'SECURITY_BLOCKER_RESET_REDIS:SECURITY_BLOCKER_RESET_REDIS_DATA_SOURCE_NAMES';

    /**
     * Specification:
     * - Specifies an array of connection options.
     *
     * @api
     *
     * @var string
     */
    public const SECURITY_BLOCKER_RESET_REDIS_CONNECTION_OPTIONS = 'SECURITY_BLOCKER_RESET_REDIS:SECURITY_BLOCKER_RESET_REDIS_CONNECTION_OPTIONS';

    /**
     * Specification:
     * - Enables/disables data persistence for a Redis connection.
     *
     * @api
     *
     * @var string
     */
    public const SECURITY_BLOCKER_RESET_REDIS_PERSISTENT_CONNECTION = 'SECURITY_BLOCKER_RESET_REDIS:SECURITY_BLOCKER_RESET_REDIS_PERSISTENT_CONNECTION';
}
