<?php

namespace FondOfKudu\Zed\JellyfishKletties;

use FondOfKudu\Zed\JellyfishKletties\Dependency\Facade\JellyfishKlettiesToKlettiesFacadeBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class JellyfishKlettiesDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_KLETTIES = 'JELLYFISH_KLETTIES:FACADE_KLETTIES';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);
        $container = $this->addKlettiesFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function addKlettiesFacade(Container $container): Container
    {
        $container[static::FACADE_KLETTIES] = static function (Container $container) {
            return new JellyfishKlettiesToKlettiesFacadeBridge($container->getLocator()->kletties()->facade());
        };

        return $container;
    }
}
