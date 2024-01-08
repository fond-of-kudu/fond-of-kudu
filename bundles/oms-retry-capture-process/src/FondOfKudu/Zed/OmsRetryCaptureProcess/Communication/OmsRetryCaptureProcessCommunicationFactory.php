<?php

namespace FondOfKudu\Zed\OmsRetryCaptureProcess\Communication;

use FondOfKudu\Zed\OmsRetryCaptureProcess\Dependency\Facade\OmsRetryCaptureProcessFacadeToPayoneFacadeInterface;
use FondOfKudu\Zed\OmsRetryCaptureProcess\OmsRetryCaptureProcessDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \FondOfKudu\Zed\OmsRetryCaptureProcess\OmsRetryCaptureProcessConfig getConfig()
 */
class OmsRetryCaptureProcessCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfKudu\Zed\OmsRetryCaptureProcess\Dependency\Facade\OmsRetryCaptureProcessFacadeToPayoneFacadeInterface
     */
    public function getPayoneFacade(): OmsRetryCaptureProcessFacadeToPayoneFacadeInterface
    {
        return $this->getProvidedDependency(OmsRetryCaptureProcessDependencyProvider::FACADE_PAYONE);
    }
}
