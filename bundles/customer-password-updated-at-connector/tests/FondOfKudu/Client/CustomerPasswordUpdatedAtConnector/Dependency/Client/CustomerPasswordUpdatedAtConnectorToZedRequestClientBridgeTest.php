<?php

namespace FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\Dependency\Client;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\ZedRequest\ZedRequestClient;
use Spryker\Shared\Kernel\Transfer\TransferInterface;

class CustomerPasswordUpdatedAtConnectorToZedRequestClientBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\ZedRequest\ZedRequestClient
     */
    protected MockObject|ZedRequestClient $zedRequestClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    protected MockObject|TransferInterface $transferMock;

    /**
     * @var \FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\Dependency\Client\CustomerPasswordUpdatedAtConnectorToZedRequestClientInterface
     */
    protected CustomerPasswordUpdatedAtConnectorToZedRequestClientInterface $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->zedRequestClientMock = $this->createMock(ZedRequestClient::class);
        $this->transferMock = $this->createMock(TransferInterface::class);
        $this->bridge = new CustomerPasswordUpdatedAtConnectorToZedRequestClientBridge($this->zedRequestClientMock);
    }

    /**
     * @return void
     */
    public function testCall(): void
    {
        $this->zedRequestClientMock->expects(static::once())
            ->method('call')
            ->with('url', $this->transferMock)
            ->willReturn($this->transferMock);

        static::assertEquals($this->bridge->call('url', $this->transferMock), $this->transferMock);
    }
}
