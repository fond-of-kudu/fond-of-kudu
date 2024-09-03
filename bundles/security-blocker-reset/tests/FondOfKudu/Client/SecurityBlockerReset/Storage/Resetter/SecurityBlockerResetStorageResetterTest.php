<?php

namespace FondOfKudu\Client\SecurityBlockerReset\Storage\Resetter;

use Codeception\Test\Unit;
use FondOfKudu\Client\SecurityBlockerReset\Redis\SecurityBlockerResetWrapperInterface;
use Generated\Shared\Transfer\SecurityCheckAuthContextTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class SecurityBlockerResetStorageResetterTest extends Unit
{
    /**
     * @var \FondOfKudu\Client\SecurityBlockerReset\Storage\Resetter\SecurityBlockerResetStorageResetter
     */
    protected SecurityBlockerResetStorageResetter $securityBlockerResetStorageResetter;

    /**
     * @var (\FondOfKudu\Client\SecurityBlockerReset\Redis\SecurityBlockerResetWrapperInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|SecurityBlockerResetWrapperInterface $securityBlockerResetWrapperMock;

    /**
     * @var (\Generated\Shared\Transfer\SecurityCheckAuthContextTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected SecurityCheckAuthContextTransfer|MockObject $securityCheckAuthContextTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->securityBlockerResetWrapperMock = $this->getMockBuilder(SecurityBlockerResetWrapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->securityCheckAuthContextTransferMock = $this->getMockBuilder(SecurityCheckAuthContextTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->securityBlockerResetStorageResetter = new SecurityBlockerResetStorageResetter(
            $this->securityBlockerResetWrapperMock,
        );
    }

    /**
     * @return void
     */
    public function testResetLoginBlock(): void
    {
        $this->securityCheckAuthContextTransferMock->expects($this->atLeastOnce())
            ->method('getTypeOrFail')
            ->willReturn('customer');

        $this->securityCheckAuthContextTransferMock->expects($this->atLeastOnce())
            ->method('getIp')
            ->willReturn('127.0.0.1');

        $this->securityCheckAuthContextTransferMock->expects($this->atLeastOnce())
            ->method('getAccount')
            ->willReturn('foobar@fondof.de');

        $this->securityBlockerResetWrapperMock->expects($this->atLeastOnce())
            ->method('del')
            ->with([
                'customer:127.0.0.1:foobar@fondof.de',
            ])
            ->willReturn(1);

        $this->assertTrue($this->securityBlockerResetStorageResetter->resetLoginBlock(
            $this->securityCheckAuthContextTransferMock,
        ));
    }

    /**
     * @return void
     */
    public function testResetLoginBlockNotUpdated(): void
    {
        $this->securityCheckAuthContextTransferMock->expects($this->atLeastOnce())
            ->method('getTypeOrFail')
            ->willReturn('customer');

        $this->securityCheckAuthContextTransferMock->expects($this->atLeastOnce())
            ->method('getIp')
            ->willReturn('127.0.0.1');

        $this->securityCheckAuthContextTransferMock->expects($this->atLeastOnce())
            ->method('getAccount')
            ->willReturn('foobar@fondof.de');

        $this->securityBlockerResetWrapperMock->expects($this->atLeastOnce())
            ->method('del')
            ->with([
                'customer:127.0.0.1:foobar@fondof.de',
            ])
            ->willReturn(0);

        $this->assertFalse($this->securityBlockerResetStorageResetter->resetLoginBlock(
            $this->securityCheckAuthContextTransferMock,
        ));
    }
}
