<?php

namespace FondOfKudu\Zed\OmsRetryCaptureProcess\Communication;

use FondOfKudu\Zed\OmsRetryCaptureProcess\Dependency\Facade\OmsRetryCatpureProcessToPayoneFacadeInterface;
use FondOfKudu\Zed\OmsRetryCaptureProcess\OmsRetryCaptureProcessDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \FondOfKudu\Zed\OmsRetryCaptureProcess\OmsRetryCaptureProcessConfig getConfig()
 */
class OmsRetryCaptureProcessCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfKudu\Zed\OmsRetryCaptureProcess\Dependency\Facade\OmsRetryCatpureProcessToPayoneFacadeInterface
     */
    public function getPayoneFacade(): OmsRetryCatpureProcessToPayoneFacadeInterface
    {
        return $this->getProvidedDependency(OmsRetryCaptureProcessDependencyProvider::FACADE_PAYONE);
    }
}
