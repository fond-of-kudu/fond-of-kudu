<?php

namespace FondOfKudu\Glue\CheckoutRestApiCountryConnector;

use FondOfKudu\Glue\CheckoutRestApiCountryConnector\Dependency\Client\CheckoutRestApiCountryConnectorToGlossaryStorageClientBridge;
use FondOfKudu\Glue\CheckoutRestApiCountryConnector\Dependency\Client\CheckoutRestApiCountryConnectorToLocaleClientBridge;
use Spryker\Glue\Kernel\AbstractBundleDependencyProvider;
use Spryker\Glue\Kernel\Container;

class CheckoutRestApiCountryConnectorDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_GLOSSARY_STORAGE = 'CLIENT_GLOSSARY_STORAGE';

    /**
     * @var string
     */
    public const CLIENT_LOCALE = 'CLIENT_LOCALE';

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);
        $container = $this->addGlossaryStorageClient($container);
        $container = $this->addLocaleClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addGlossaryStorageClient(Container $container): Container
    {
        $container->set(static::CLIENT_GLOSSARY_STORAGE, function (Container $container) {
            return new CheckoutRestApiCountryConnectorToGlossaryStorageClientBridge(
                $container->getLocator()->glossaryStorage()->client(),
            );
        });

        return $container;
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addLocaleClient(Container $container): Container
    {
        $container->set(static::CLIENT_LOCALE, function (Container $container) {
            return new CheckoutRestApiCountryConnectorToLocaleClientBridge(
                $container->getLocator()->locale()->client(),
            );
        });

        return $container;
    }
}
