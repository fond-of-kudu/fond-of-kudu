<?php

namespace FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client;

use Spryker\Client\Locale\LocaleClientInterface;

class ProductImageStorageConnectorToLocaleClientBridge implements ProductImageStorageConnectorToLocaleClientInterface
{
    protected LocaleClientInterface $localeClient;

    /**
     * @param \Spryker\Client\Locale\LocaleClientInterface $localeClient
     */
    public function __construct(LocaleClientInterface $localeClient)
    {
        $this->localeClient = $localeClient;
    }

    /**
     * @return string
     */
    public function getCurrentLocale(): string
    {
        return $this->localeClient->getCurrentLocale();
    }
}
