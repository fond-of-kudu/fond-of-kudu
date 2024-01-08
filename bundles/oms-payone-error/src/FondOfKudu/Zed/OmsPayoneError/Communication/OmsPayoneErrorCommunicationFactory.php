<?php

namespace FondOfKudu\Zed\OmsPayoneError\Communication;

use FondOfKudu\Zed\OmsPayoneError\Dependency\Facade\OmsPayoneErrorToPayoneFacadeInterface;
use FondOfKudu\Zed\OmsPayoneError\OmsPayoneErrorDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \FondOfKudu\Zed\OmsPayoneError\OmsPayoneErrorConfig getConfig()
 * @method \FondOfKudu\Zed\OmsPayoneError\Persistence\OmsPayoneErrorQueryContainerInterface getQueryContainer()
 * @method \FondOfKudu\Zed\OmsPayoneError\Persistence\OmsPayoneErrorRepositoryInterface getRepository()
 * @method \FondOfKudu\Zed\OmsPayoneError\Business\OmsPayoneErrorFacadeInterface getFacade()
 */
class OmsPayoneErrorCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfKudu\Zed\OmsPayoneError\Dependency\Facade\OmsPayoneErrorToPayoneFacadeInterface
     */
    public function getPayoneFacade(): OmsPayoneErrorToPayoneFacadeInterface
    {
        return $this->getProvidedDependency(OmsPayoneErrorDependencyProvider::FACADE_PAYONE);
    }
}
