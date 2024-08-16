<?php

namespace FondOfKudu\Zed\KlettiesApi\Communication\Plugin\Api;

use Codeception\Test\Unit;
use Exception;
use FondOfKudu\Zed\KlettiesApi\Business\KlettiesApiFacade;
use FondOfKudu\Zed\KlettiesApi\Business\KlettiesApiFacadeInterface;
use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Api\Business\Exception\ApiDispatchingException;
use Spryker\Zed\Kernel\Business\AbstractFacade;

class KlettiesApiResourcePluginTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Communication\Plugin\Api\KlettiesApiResourcePlugin
     */
    protected KlettiesApiResourcePlugin $plugin;

    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Business\KlettiesApiFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected KlettiesApiFacadeInterface|MockObject $facadeMock;

    /**
     * @var \Generated\Shared\Transfer\ApiItemTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ApiItemTransfer|MockObject $apiItemTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ApiCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ApiCollectionTransfer|MockObject $apiCollectionTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ApiDataTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ApiDataTransfer|MockObject $apiDataTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ApiRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ApiRequestTransfer|MockObject $apiRequestTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->apiItemTransferMock = $this->getMockBuilder(ApiItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facadeMock = $this->getMockBuilder(KlettiesApiFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiCollectionTransferMock = $this->getMockBuilder(ApiCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiDataTransferMock = $this->getMockBuilder(ApiDataTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiRequestTransferMock = $this->getMockBuilder(ApiRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new KlettiesApiResourcePlugin();
        $this->plugin->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testGet(): void
    {
        $catch = null;
        try {
            $this->plugin->get(1);
        } catch (Exception $exception) {
            $catch = $exception;
        }

        $this->assertNotNull($catch);
        $this->assertInstanceOf(ApiDispatchingException::class, $catch);
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $this->facadeMock->expects($this->once())->method('updateKlettiesOrder')->willReturn($this->apiItemTransferMock);
        $this->plugin->update(1, $this->apiDataTransferMock);
    }

    /**
     * @return void
     */
    public function testAdd(): void
    {
        $catch = null;
        try {
            $this->plugin->add($this->apiDataTransferMock);
        } catch (Exception $exception) {
            $catch = $exception;
        }

        $this->assertNotNull($catch);
        $this->assertInstanceOf(ApiDispatchingException::class, $catch);
    }

    /**
     * @return void
     */
    public function testRemove(): void
    {
        $catch = null;
        try {
            $this->plugin->remove(1);
        } catch (Exception $exception) {
            $catch = $exception;
        }

        $this->assertNotNull($catch);
        $this->assertInstanceOf(ApiDispatchingException::class, $catch);
    }

    /**
     * @return void
     */
    public function testFind(): void
    {
        $this->facadeMock->expects($this->once())->method('findKlettiesOrder')->willReturn($this->apiCollectionTransferMock);
        $this->plugin->find($this->apiRequestTransferMock);
    }
}
