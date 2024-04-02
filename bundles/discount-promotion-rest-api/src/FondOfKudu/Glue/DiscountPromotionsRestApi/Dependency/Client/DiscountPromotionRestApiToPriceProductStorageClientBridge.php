<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client;

use Spryker\Client\PriceProductStorage\PriceProductStorageClientInterface;

class DiscountPromotionRestApiToPriceProductStorageClientBridge implements DiscountPromotionRestApiToPriceProductStorageClientInterface
{
    /**
     * @var \Spryker\Client\PriceProductStorage\PriceProductStorageClientInterface
     */
    protected $priceProductStorageClient;

    /**
     * @param \Spryker\Client\PriceProductStorage\PriceProductStorageClientInterface $priceProductStorageClient
     */
    public function __construct(PriceProductStorageClientInterface $priceProductStorageClient)
    {
        $this->priceProductStorageClient = $priceProductStorageClient;
    }

    /**
     * @inheritDoc
     */
    public function getPriceProductAbstractTransfers(int $idProductAbstract): array
    {
        return $this->priceProductStorageClient->getPriceProductAbstractTransfers($idProductAbstract);
    }
}
