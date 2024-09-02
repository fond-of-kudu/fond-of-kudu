<?php

namespace FondOfKudu\Glue\SecurityBlockerReset;

use FondOfKudu\Glue\SecurityBlockerReset\Customer\Storage\SecurityBlockerResetStorage;
use FondOfKudu\Glue\SecurityBlockerReset\Customer\Storage\SecurityBlockerResetStorageInterface;
use Spryker\Glue\Kernel\AbstractFactory;

/**
 * @method \FondOfKudu\Client\SecurityBlockerReset\SecurityBlockerResetClientInterface getClient()
 */
class SecurityBlockerResetFactory extends AbstractFactory
{
    /**
     * @return \FondOfKudu\Glue\SecurityBlockerReset\Customer\Storage\SecurityBlockerResetStorageInterface
     */
    public function createSecurityBlockerResetStorage(): SecurityBlockerResetStorageInterface
    {
        return new SecurityBlockerResetStorage($this->getClient());
    }
}
