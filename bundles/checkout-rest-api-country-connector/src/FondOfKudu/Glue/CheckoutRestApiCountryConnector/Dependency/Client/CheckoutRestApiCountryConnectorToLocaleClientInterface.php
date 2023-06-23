<?php

namespace FondOfKudu\Glue\CheckoutRestApiCountryConnector\Dependency\Client;

interface CheckoutRestApiCountryConnectorToLocaleClientInterface
{
    /**
     * Specification:
     * - Returns current locale name.
     *
     * @api
     *
     * @return string
     */
    public function getCurrentLocale(): string;
}
