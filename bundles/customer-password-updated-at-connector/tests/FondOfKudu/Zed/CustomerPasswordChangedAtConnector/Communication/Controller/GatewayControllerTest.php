<?php

namespace FondOfKudu\Zed\CustomerPasswordChangedAtConnector\Communication\Controller;

use Codeception\Test\Unit;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\CustomerPasswordUpdatedAtConnectorFacadeInterface;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Communication\Controller\GatewayController;
use Generated\Shared\Transfer\CustomerPasswordUpdatedResponseTransfer;
use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class GatewayControllerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected MockObject|CustomerTransfer $customerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerResponseTransfer
     */
    protected MockObject|CustomerResponseTransfer $customerResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerPasswordUpdatedResponseTransfer
     */
    protected MockObject|CustomerPasswordUpdatedResponseTransfer $customerPasswordUpdatedResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\CustomerPasswordUpdatedAtConnectorFacadeInterface
     */
    protected MockObject|CustomerPasswordUpdatedAtConnectorFacadeInterface $facadeMock;

    /**
     * @var \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Communication\Controller\GatewayController
     */
    protected GatewayController $controller;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->customerTransferMock = $this->createMock(CustomerTransfer::class);
        $this->customerResponseTransferMock = $this->createMock(CustomerResponseTransfer::class);
        $this->customerPasswordUpdatedResponseTransferMock = $this->createMock(CustomerPasswordUpdatedResponseTransfer::class);
        $this->facadeMock = $this->createMock(CustomerPasswordUpdatedAtConnectorFacadeInterface::class);
        $this->controller = new class ($this->facadeMock) extends GatewayController {
            /**
             * @var \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\CustomerPasswordUpdatedAtConnectorFacadeInterface
             */
            protected $facade;

            /**
             * @param \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\CustomerPasswordUpdatedAtConnectorFacadeInterface $facade
             */
            public function __construct(CustomerPasswordUpdatedAtConnectorFacadeInterface $facade)
            {
                $this->facade = $facade;
            }

            /**
             * @return \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\CustomerPasswordUpdatedAtConnectorFacadeInterface
             */
            public function getFacade(): CustomerPasswordUpdatedAtConnectorFacadeInterface
            {
                return $this->facade;
            }
        };
    }

    /**
     * @return void
     */
    public function testRestorePasswordAction(): void
    {
        $this->facadeMock->expects(static::once())
            ->method('restorePassword')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerResponseTransferMock);

        static::assertEquals(
            $this->controller->restorePasswordAction($this->customerTransferMock),
            $this->customerResponseTransferMock,
        );
    }

    /**
     * @return void
     */
    public function testPasswordUpdatedAction(): void
    {
        $this->facadeMock->expects(static::once())
            ->method('passwordUpdated')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerPasswordUpdatedResponseTransferMock);

        static::assertEquals(
            $this->controller->passwordUpdatedAction($this->customerTransferMock),
            $this->customerPasswordUpdatedResponseTransferMock,
        );
    }
}
