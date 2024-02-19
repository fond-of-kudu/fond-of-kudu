<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client;

use Generated\Shared\Transfer\CurrencyTransfer;

interface DiscountPromotionsRestApiToCurrencyClientInterface
{
    /**
     * @return \Generated\Shared\Transfer\CurrencyTransfer
     */
    public function getCurrent(): CurrencyTransfer;
}
