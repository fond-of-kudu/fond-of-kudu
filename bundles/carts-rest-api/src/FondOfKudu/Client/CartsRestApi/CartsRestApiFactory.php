<?php

namespace FondOfKudu\Client\CartsRestApi;

use FondOfKudu\Client\CartsRestApi\Zed\CartsRestApiZedStub;
use FondOfKudu\Client\CartsRestApi\Zed\CartsRestApiZedStubInterface;
use Spryker\Client\CartsRestApi\CartsRestApiFactory as SprykerCartsRestApiFactory;

class CartsRestApiFactory extends SprykerCartsRestApiFactory
{
    /**
     * @return \FondOfKudu\Client\CartsRestApi\Zed\CartsRestApiZedStubInterface
     */
    public function createCartsRestApiZedStub(): CartsRestApiZedStubInterface
    {
        return new CartsRestApiZedStub($this->getZedRequestClient());
    }
}
