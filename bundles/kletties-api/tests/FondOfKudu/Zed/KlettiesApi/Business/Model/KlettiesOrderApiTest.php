<?php

namespace FondOfKudu\Zed\KlettiesApi\Business\Model;

use Codeception\Test\Unit;
use Exception;
use FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToApiFacadeBridge;
use FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToKlettiesFacadeBridge;
use FondOfKudu\Zed\KlettiesApi\Persistence\KlettiesApiRepository;
use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;
use Generated\Shared\Transfer\KlettiesOrderTransfer;
use Spryker\Zed\Api\Business\Exception\EntityNotSavedException;

class KlettiesOrderApiTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Business\Model\KlettiesOrderApiInterface
     */
    protected $orderApi;

    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToApiFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $klettiesQueryContainerMock;

    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToKlettiesFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $klettiesApiFacadeMock;

    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Persistence\KlettiesApiRepositoryInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $repositoryMock;

    /**
     * @var \Generated\Shared\Transfer\ApiDataTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $apiDataTransferMock;

    /**
     * @var \Generated\Shared\Transfer\KlettiesOrderTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $klettiesOrderTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ApiItemTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $apiItemTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ApiRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $apiRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ApiCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $apiCollectionTransferMock;

    /**
     * @return void
     */
    public function _before(): void
    {
        parent::_before();

        $this->klettiesApiFacadeMock = $this->getMockBuilder(KlettiesApiToKlettiesFacadeBridge::class)->disableOriginalConstructor()->getMock();
        $this->klettiesQueryContainerMock = $this->getMockBuilder(KlettiesApiToApiFacadeBridge::class)->disableOriginalConstructor()->getMock();
        $this->repositoryMock = $this->getMockBuilder(KlettiesApiRepository::class)->disableOriginalConstructor()->getMock();
        $this->apiDataTransferMock = $this->getMockBuilder(ApiDataTransfer::class)->disableOriginalConstructor()->getMock();
        $this->apiItemTransferMock = $this->getMockBuilder(ApiItemTransfer::class)->disableOriginalConstructor()->getMock();
        $this->klettiesOrderTransferMock = $this->getMockBuilder(KlettiesOrderTransfer::class)->disableOriginalConstructor()->getMock();
        $this->apiRequestTransferMock = $this->getMockBuilder(ApiRequestTransfer::class)->disableOriginalConstructor()->getMock();
        $this->apiCollectionTransferMock = $this->getMockBuilder(ApiCollectionTransfer::class)->disableOriginalConstructor()->getMock();

        $this->orderApi = new KlettiesOrderApi(
            $this->klettiesQueryContainerMock,
            $this->klettiesApiFacadeMock,
            $this->repositoryMock,
        );
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $this->apiDataTransferMock->method('getData')->willReturn([]);
        $this->klettiesApiFacadeMock->expects($this->once())->method('updateKlettiesOrder')->willReturn($this->klettiesOrderTransferMock);
        $this->klettiesQueryContainerMock->expects($this->once())->method('createApiItem')->willReturn($this->apiItemTransferMock);
        $this->klettiesOrderTransferMock->expects($this->once())->method('getId')->willReturn(1);

        $this->orderApi->update(1, $this->apiDataTransferMock);
    }

    /**
     * @return void
     */
    public function testUpdateThrowsException(): void
    {
        $this->apiDataTransferMock->method('getData')->willReturn([]);
        $this->klettiesApiFacadeMock->expects($this->once())->method('updateKlettiesOrder')->willThrowException(new Exception(''));
        $this->klettiesQueryContainerMock->expects($this->never())->method('createApiItem');
        $this->klettiesOrderTransferMock->expects($this->never())->method('getId');

        $catch = null;
        try {
            $this->orderApi->update(1, $this->apiDataTransferMock);
        } catch (Exception $exception) {
            $catch = $exception;
        }

        $this->assertNotNull($catch);
        $this->assertInstanceOf(EntityNotSavedException::class, $catch);
    }

    /**
     * @return void
     */
    public function testFind(): void
    {
        $this->repositoryMock->expects($this->once())->method('find')->willReturn($this->apiCollectionTransferMock);
        $this->orderApi->find($this->apiRequestTransferMock);
    }
}
