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
use Spryker\Zed\Api\Business\Exception\ApiDispatchingException;
use Spryker\Zed\Kernel\Business\AbstractFacade;

class KlettiesApiResourcePluginTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Communication\Plugin\Api\KlettiesApiResourcePlugin
     */
    protected $plugin;

    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Business\KlettiesApiFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $facadeMock;

    /**
     * @var \Generated\Shared\Transfer\ApiItemTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $apiItemTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ApiCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $apiCollectionTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ApiDataTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $apiDataTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ApiRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $apiRequestTransferMock;

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

        $this->plugin = new class ($this->facadeMock) extends KlettiesApiResourcePlugin {
            /**
             * @var \FondOfKudu\Zed\KlettiesApi\Business\KlettiesApiFacadeInterface
             */
            public $facade;

            /**
             *  constructor.
             *
             * @param \FondOfKudu\Zed\KlettiesApi\Business\KlettiesApiFacadeInterface $klettiesFacade
             */
            public function __construct(KlettiesApiFacadeInterface $klettiesFacade)
            {
                $this->facade = $klettiesFacade;
            }

            /**
             * @return \FondOfKudu\Zed\KlettiesApi\Business\KlettiesApiFacadeInterface|\Spryker\Zed\Kernel\Business\AbstractFacade
             */
            protected function getFacade(): AbstractFacade
            {
                return $this->facade;
            }
        };
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
