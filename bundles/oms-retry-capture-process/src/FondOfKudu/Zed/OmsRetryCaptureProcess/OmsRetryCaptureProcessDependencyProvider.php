<?php

namespace FondOfKudu\Zed\OmsRetryCaptureProcess;

use FondOfKudu\Zed\OmsRetryCaptureProcess\Dependency\Facade\OmsRetryCaptureProcessFacadeToPayoneFacadeBridge;
use FondOfKudu\Zed\OmsRetryCaptureProcess\Dependency\Facade\OmsRetryCaptureProcessFacadeToPayoneFacadeInterface;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class OmsRetryCaptureProcessDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_PAYONE = 'FACADE_PAYONE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = $this->addPayoneFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPayoneFacade(Container $container): Container
    {
        $container[static::FACADE_PAYONE] = static fn (
            Container $container
        ): OmsRetryCaptureProcessFacadeToPayoneFacadeInterface => new OmsRetryCaptureProcessFacadeToPayoneFacadeBridge(
            $container->getLocator()->payone()->facade(),
        );

        return $container;
    }
}
