<?php

namespace FondOfKudu\Glue\CheckoutRestApiCountryConnector\Dependency\Client;

use Spryker\Client\GlossaryStorage\GlossaryStorageClientInterface;

class CheckoutRestApiCountryConnectorToGlossaryStorageClientBridge implements CheckoutRestApiCountryConnectorToGlossaryStorageClientInterface
{
    /**
     * @var \Spryker\Client\GlossaryStorage\GlossaryStorageClientInterface
     */
    protected $glossaryClient;

    /**
     * @param \Spryker\Client\GlossaryStorage\GlossaryStorageClientInterface $glossaryClient
     */
    public function __construct(GlossaryStorageClientInterface $glossaryClient)
    {
        $this->glossaryClient = $glossaryClient;
    }

    /**
     * @param string $id
     * @param string $localeName
     * @param array $parameters
     *
     * @return string
     */
    public function translate(string $id, string $localeName, array $parameters = []): string
    {
        return $this->glossaryClient->translate($id, $localeName, $parameters);
    }
}
