<?php

namespace FondOfKudu\Glue\SecurityBlockerReset\Customer\Storage;

use Codeception\Test\Unit;
use FondOfKudu\Client\SecurityBlockerReset\SecurityBlockerResetClientInterface;
use FondOfKudu\Glue\SecurityBlockerReset\SecurityBlockerResetConfig;
use Generated\Shared\Transfer\RestCustomerRestorePasswordAttributesTransfer;
use Generated\Shared\Transfer\SecurityCheckAuthContextTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Symfony\Component\HttpFoundation\Request;

class SecurityBlockerResetStorageTest extends Unit
{
    /**
     * @var \FondOfKudu\Glue\SecurityBlockerReset\Customer\Storage\SecurityBlockerResetStorage
     */
    protected SecurityBlockerResetStorage $securityBlockerResetStorage;

    /**
     * @var (\FondOfKudu\Client\SecurityBlockerReset\SecurityBlockerResetClientInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|SecurityBlockerResetClientInterface $securityBlockerResetClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|(\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected RestRequestInterface|MockObject $restRequestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|(\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected RestResponseInterface|MockObject $restResponseMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|(\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected MockObject|RestResourceInterface $restResourceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|(\Symfony\Component\HttpFoundation\Request&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected MockObject|Request $requestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCustomerRestorePasswordAttributesTransfer
     */
    protected MockObject|RestCustomerRestorePasswordAttributesTransfer $restCustomerRestorePasswordAttributesTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->securityBlockerResetClientMock = $this->getMockBuilder(SecurityBlockerResetClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceMock = $this->getMockBuilder(RestResourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->requestMock = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCustomerRestorePasswordAttributesTransferMock = $this->getMockBuilder(RestCustomerRestorePasswordAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->securityBlockerResetStorage = new SecurityBlockerResetStorage(
            $this->securityBlockerResetClientMock,
        );
    }

    /**
     * @return void
     */
    public function testResetLoginBlock(): void
    {
        $this->restRequestMock->expects($this->atLeastOnce())
            ->method('getResource')
            ->willReturn($this->restResourceMock);

        $this->restResourceMock->expects($this->atLeastOnce())
            ->method('getType')
            ->willReturn(SecurityBlockerResetConfig::RESOURCE_CUSTOMER_RESTORE_PASSWORD);

        $this->restRequestMock->expects($this->atLeastOnce())
            ->method('getHttpRequest')
            ->willReturn($this->requestMock);

        $this->requestMock->expects($this->atLeastOnce())
            ->method('getMethod')
            ->willReturn(Request::METHOD_PATCH);

        $this->restResourceMock->expects($this->atLeastOnce())
            ->method('getAttributes')
            ->willReturn($this->restCustomerRestorePasswordAttributesTransferMock);

        $this->requestMock->expects($this->atLeastOnce())
            ->method('getClientIp')
            ->willReturn('127.0.0.1');

        $this->restCustomerRestorePasswordAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getUsername')
            ->willReturn('foobar@fondof.de');

        $this->securityBlockerResetClientMock->expects($this->atLeastOnce())
            ->method('resetLoginBlock')
            ->with((new SecurityCheckAuthContextTransfer())
                ->setType(SecurityBlockerResetConfig::SECURITY_BLOCKER_RESET_CUSTOMER_ENTITY_TYPE)
                ->setIp('127.0.0.1')
                ->setAccount('foobar@fondof.de'))
            ->willReturn(true);

        $this->securityBlockerResetStorage->resetLoginBlock('action', $this->restRequestMock, $this->restResponseMock);
    }

    /**
     * @return void
     */
    public function testResetLoginBlockIgnoreRequest(): void
    {
        $this->restRequestMock->expects($this->atLeastOnce())
            ->method('getResource')
            ->willReturn($this->restResourceMock);

        $this->restResourceMock->expects($this->atLeastOnce())
            ->method('getType')
            ->willReturn(SecurityBlockerResetConfig::RESOURCE_CUSTOMER_RESTORE_PASSWORD);

        $this->restRequestMock->expects($this->atLeastOnce())
            ->method('getHttpRequest')
            ->willReturn($this->requestMock);

        $this->requestMock->expects($this->atLeastOnce())
            ->method('getMethod')
            ->willReturn(Request::METHOD_PATCH . 'other');

        $this->restResourceMock->expects($this->never())
            ->method('getAttributes')
            ->willReturn($this->restCustomerRestorePasswordAttributesTransferMock);

        $this->requestMock->expects($this->never())
            ->method('getClientIp')
            ->willReturn('127.0.0.1');

        $this->restCustomerRestorePasswordAttributesTransferMock->expects($this->never())
            ->method('getUsername')
            ->willReturn('foobar@fondof.de');

        $this->securityBlockerResetClientMock->expects($this->never())
            ->method('resetLoginBlock')
            ->with((new SecurityCheckAuthContextTransfer())
                ->setType(SecurityBlockerResetConfig::SECURITY_BLOCKER_RESET_CUSTOMER_ENTITY_TYPE)
                ->setIp('127.0.0.1')
                ->setAccount('foobar@fondof.de'))
            ->willReturn(true);

        $this->securityBlockerResetStorage->resetLoginBlock('action', $this->restRequestMock, $this->restResponseMock);
    }
}
