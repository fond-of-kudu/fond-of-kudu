<?php

namespace FondOfKudu\Zed\KlettiesApi\Communication;

use Codeception\Test\Unit;
use FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToApiFacadeBridge;
use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Spryker\Zed\Api\Business\ApiFacadeInterface;

class KlettiesApiToApiFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToApiFacadeBridge
     */
    protected $bridge;

    /**
     * @var \Spryker\Zed\Api\Business\ApiFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $apiFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\ApiItemTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $apiItemTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ApiCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $collectionTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->apiFacadeMock = $this->getMockBuilder(ApiFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiItemTransferMock = $this->getMockBuilder(ApiItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->collectionTransferMock = $this->getMockBuilder(ApiCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new KlettiesApiToApiFacadeBridge(
            $this->apiFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testCreateApiItem(): void
    {
        $this->apiFacadeMock->expects($this->once())
            ->method('createApiItem')
            ->willReturn($this->apiItemTransferMock);

        $this->bridge->createApiItem($this->apiItemTransferMock, 1);
    }

    /**
     * @return void
     */
    public function testCreateApiCollection(): void
    {
        $this->apiFacadeMock->expects($this->once())
            ->method('createApiCollection')
            ->willReturn($this->collectionTransferMock);

        $this->bridge->createApiCollection([]);
    }
}
