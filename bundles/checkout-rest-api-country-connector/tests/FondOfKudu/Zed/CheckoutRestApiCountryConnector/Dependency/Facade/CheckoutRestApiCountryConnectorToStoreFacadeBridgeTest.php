<?php

namespace FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\StoreTransfer;
use Spryker\Zed\Store\Business\StoreFacade;

class CheckoutRestApiCountryConnectorToStoreFacadeBridgeTest extends Unit
{
    /**
     * @var \Spryker\Zed\Store\Business\StoreFacade|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $storeFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\StoreTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $storeTransfer;

    /**
     * @var \FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToStoreFacadeBridge
     */
    protected $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->storeFacadeMock = $this->getMockBuilder(StoreFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeTransfer = $this->getMockBuilder(StoreTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new CheckoutRestApiCountryConnectorToStoreFacadeBridge($this->storeFacadeMock);
    }

    /**
     * @return void
     */
    public function testGetCurrentStore(): void
    {
        $this->storeFacadeMock->expects(static::atLeastOnce())
            ->method('getCurrentStore')
            ->willReturn($this->storeTransfer);

        $this->bridge->getCurrentStore();
    }
}
