<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client;

use Generated\Shared\Transfer\CurrencyTransfer;
use Spryker\Client\Currency\CurrencyClientInterface;

class DiscountPromotionsRestApiToCurrencyClientBridge implements DiscountPromotionsRestApiToCurrencyClientInterface
{
    private CurrencyClientInterface $currencyClient;

    /**
     * @param \Spryker\Client\Currency\CurrencyClientInterface $currencyClient
     */
    public function __construct(CurrencyClientInterface $currencyClient)
    {
        $this->currencyClient = $currencyClient;
    }

    /**
     * @return \Generated\Shared\Transfer\CurrencyTransfer
     */
    public function getCurrent(): CurrencyTransfer
    {
        return $this->currencyClient->getCurrent();
    }
}
