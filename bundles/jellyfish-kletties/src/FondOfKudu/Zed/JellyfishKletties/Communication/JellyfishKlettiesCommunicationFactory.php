<?php

namespace FondOfKudu\Zed\JellyfishKletties\Communication;

use FondOfKudu\Zed\JellyfishKletties\Dependency\Facade\JellyfishKlettiesToKlettiesFacadeInterface;
use FondOfKudu\Zed\JellyfishKletties\JellyfishKlettiesDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \FondOfKudu\Zed\JellyfishKletties\JellyfishKlettiesConfig getConfig()
 * @method \FondOfKudu\Zed\JellyfishKletties\Business\JellyfishKlettiesFacadeInterface getFacade()
 */
class JellyfishKlettiesCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfKudu\Zed\JellyfishKletties\Dependency\Facade\JellyfishKlettiesToKlettiesFacadeInterface
     */
    public function getKlettiesFacade(): JellyfishKlettiesToKlettiesFacadeInterface
    {
        return $this->getProvidedDependency(JellyfishKlettiesDependencyProvider::FACADE_KLETTIES);
    }
}
