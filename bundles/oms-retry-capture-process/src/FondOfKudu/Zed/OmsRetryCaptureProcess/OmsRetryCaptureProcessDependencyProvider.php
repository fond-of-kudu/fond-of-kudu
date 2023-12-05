<?php

namespace FondOfKudu\Zed\OmsRetryCaptureProcess;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class OmsRetryCaptureProcessDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        return $container;
    }
}
