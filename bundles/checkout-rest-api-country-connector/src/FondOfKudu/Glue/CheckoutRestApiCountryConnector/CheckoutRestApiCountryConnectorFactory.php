<?php

namespace FondOfKudu\Glue\CheckoutRestApiCountryConnector;

use FondOfKudu\Glue\CheckoutRestApiCountryConnector\Dependency\Client\CheckoutRestApiCountryConnectorToGlossaryStorageClientInterface;
use FondOfKudu\Glue\CheckoutRestApiCountryConnector\Dependency\Client\CheckoutRestApiCountryConnectorToLocaleClientInterface;
use FondOfKudu\Glue\CheckoutRestApiCountryConnector\Processor\Mapper\CountryMapper;
use FondOfKudu\Glue\CheckoutRestApiCountryConnector\Processor\Mapper\CountryMapperInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class CheckoutRestApiCountryConnectorFactory extends AbstractFactory
{
    /**
     * @return \FondOfKudu\Glue\CheckoutRestApiCountryConnector\Processor\Mapper\CountryMapperInterface
     */
    public function createCountryMapper(): CountryMapperInterface
    {
        return new CountryMapper(
            $this->getGlossaryStorageClient(),
            $this->getLocaleClient(),
        );
    }

    /**
     * @return \FondOfKudu\Glue\CheckoutRestApiCountryConnector\Dependency\Client\CheckoutRestApiCountryConnectorToGlossaryStorageClientInterface
     */
    protected function getGlossaryStorageClient(): CheckoutRestApiCountryConnectorToGlossaryStorageClientInterface
    {
        return $this->getProvidedDependency(CheckoutRestApiCountryConnectorDependencyProvider::CLIENT_GLOSSARY_STORAGE);
    }

    /**
     * @return \FondOfKudu\Glue\CheckoutRestApiCountryConnector\Dependency\Client\CheckoutRestApiCountryConnectorToLocaleClientInterface
     */
    protected function getLocaleClient(): CheckoutRestApiCountryConnectorToLocaleClientInterface
    {
        return $this->getProvidedDependency(CheckoutRestApiCountryConnectorDependencyProvider::CLIENT_LOCALE);
    }
}
