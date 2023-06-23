<?php

namespace FondOfKudu\Glue\CheckoutRestApiCountryConnector\Dependency\Client;

interface CheckoutRestApiCountryConnectorToGlossaryStorageClientInterface
{
    /**
     * @param string $id
     * @param string $localeName
     * @param array $parameters
     *
     * @return string
     */
    public function translate(string $id, string $localeName, array $parameters = []): string;
}
