<?php

namespace FondOfKudu\Glue\CheckoutRestApiCountryConnector\Dependency\Client;

use Spryker\Client\Locale\LocaleClientInterface;

class CheckoutRestApiCountryConnectorToLocaleClientBridge implements CheckoutRestApiCountryConnectorToLocaleClientInterface
{
    /**
     * @var \Spryker\Client\Locale\LocaleClientInterface
     */
    private LocaleClientInterface $localeClient;

    /**
     * @param \Spryker\Client\Locale\LocaleClientInterface $localeClient
     */
    public function __construct(LocaleClientInterface $localeClient)
    {
        $this->localeClient = $localeClient;
    }

    /**
     * Specification:
     * - Returns current locale name.
     *
     * @api
     *
     * @return string
     */
    public function getCurrentLocale(): string
    {
        return $this->localeClient->getCurrentLocale();
    }
}
