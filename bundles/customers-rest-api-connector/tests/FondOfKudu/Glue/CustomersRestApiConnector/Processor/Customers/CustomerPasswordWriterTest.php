<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector\Processor\Customers;

use Codeception\Test\Unit;
use FondOfKudu\Glue\CustomersRestApiConnector\Dependency\Client\CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientBridge;
use FondOfKudu\Glue\CustomersRestApiConnector\Dependency\Client\CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientInterface;
use FondOfKudu\Glue\CustomersRestApiConnector\Processor\Mapper\CustomerRestorePasswordResourceMapper;
use FondOfKudu\Glue\CustomersRestApiConnector\Processor\Mapper\CustomerRestorePasswordResourceMapperInterface;
use FondOfKudu\Glue\CustomersRestApiConnector\Processor\Validation\RestApiError;
use FondOfKudu\Glue\CustomersRestApiConnector\Processor\Validation\RestApiErrorInterface;
use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCustomerRestorePasswordAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResource;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilder;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponse;
use Symfony\Component\HttpFoundation\Response;

class CustomerPasswordWriterTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Glue\CustomersRestApiConnector\Dependency\Client\CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientInterface
     */
    protected MockObject|CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientInterface $customerPasswordUpdateAtConnectorClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected MockObject|RestResourceBuilderInterface $restResourceBuilderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Glue\CustomersRestApiConnector\Processor\Mapper\CustomerRestorePasswordResourceMapperInterface
     */
    protected MockObject|CustomerRestorePasswordResourceMapperInterface $customerRestorePasswordResourceMapperMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Glue\CustomersRestApiConnector\Processor\Validation\RestApiErrorInterface
     */
    protected MockObject|RestApiErrorInterface $restApiErrorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCustomerRestorePasswordAttributesTransfer
     */
    protected MockObject|RestCustomerRestorePasswordAttributesTransfer $restCustomerRestorePasswordAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponse
     */
    protected MockObject|RestResponse $restResponseMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResource
     */
    protected MockObject|RestResource $restResourceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected MockObject|CustomerTransfer $customerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerResponseTransfer
     */
    protected MockObject|CustomerResponseTransfer $customerResponseTransferMock;

    /**
     * @var \FondOfKudu\Glue\CustomersRestApiConnector\Processor\Customers\CustomerPasswordWriterInterface
     */
    protected CustomerPasswordWriterInterface $customerPasswordWriter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->customerPasswordUpdateAtConnectorClientMock = $this->createMock(CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientBridge::class);
        $this->restResourceBuilderMock = $this->createMock(RestResourceBuilder::class);
        $this->customerRestorePasswordResourceMapperMock = $this->createMock(CustomerRestorePasswordResourceMapper::class);
        $this->restApiErrorMock = $this->createMock(RestApiError::class);
        $this->restCustomerRestorePasswordAttributesTransferMock = $this->createMock(RestCustomerRestorePasswordAttributesTransfer::class);
        $this->customerTransferMock = $this->createMock(CustomerTransfer::class);
        $this->customerResponseTransferMock = $this->createMock(CustomerResponseTransfer::class);
        $this->restResourceMock = $this->createMock(RestResource::class);
        $this->restResponseMock = $this->createMock(RestResponse::class);
        $this->customerPasswordWriter = new CustomerPasswordWriter(
            $this->customerPasswordUpdateAtConnectorClientMock,
            $this->restResourceBuilderMock,
            $this->customerRestorePasswordResourceMapperMock,
            $this->restApiErrorMock,
        );
    }

    /**
     * @return void
     */
    public function testRestorePasswordSuccess(): void
    {
        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restCustomerRestorePasswordAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getPassword')
            ->willReturn('password');

        $this->restCustomerRestorePasswordAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getConfirmPassword')
            ->willReturn('password');

        $this->customerRestorePasswordResourceMapperMock->expects(static::atLeastOnce())
            ->method('mapCustomerRestorePasswordAttributesToCustomerTransfer')
            ->with($this->restCustomerRestorePasswordAttributesTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->customerPasswordUpdateAtConnectorClientMock->expects(static::atLeastOnce())
            ->method('restorePassword')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerResponseTransferMock);

        $this->customerResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccess')
            ->willReturn(true);

        $this->restResponseMock->expects(static::atLeastOnce())
            ->method('setStatus')
            ->with(Response::HTTP_NO_CONTENT)
            ->willReturn($this->restResponseMock);

        $this->customerPasswordWriter->restorePassword($this->restCustomerRestorePasswordAttributesTransferMock);
    }

    /**
     * @return void
     */
    public function testRestorePasswordFailedPasswordNotMatch(): void
    {
        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restCustomerRestorePasswordAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getPassword')
            ->willReturn('password111');

        $this->restCustomerRestorePasswordAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getConfirmPassword')
            ->willReturn('password222');

        $this->restApiErrorMock->expects(static::atLeastOnce())
            ->method('addPasswordsDoNotMatchError')
            ->with(
                $this->restResponseMock,
                RestCustomerRestorePasswordAttributesTransfer::PASSWORD,
                RestCustomerRestorePasswordAttributesTransfer::CONFIRM_PASSWORD,
            );

        $this->customerRestorePasswordResourceMapperMock->expects(static::never())
            ->method('mapCustomerRestorePasswordAttributesToCustomerTransfer');

        $this->customerPasswordWriter->restorePassword($this->restCustomerRestorePasswordAttributesTransferMock);
    }

    /**
     * @return void
     */
    public function testRestorePasswordFailedResponseError(): void
    {
        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->restCustomerRestorePasswordAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getPassword')
            ->willReturn('password');

        $this->restCustomerRestorePasswordAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getConfirmPassword')
            ->willReturn('password');

        $this->customerRestorePasswordResourceMapperMock->expects(static::atLeastOnce())
            ->method('mapCustomerRestorePasswordAttributesToCustomerTransfer')
            ->with($this->restCustomerRestorePasswordAttributesTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->customerPasswordUpdateAtConnectorClientMock->expects(static::atLeastOnce())
            ->method('restorePassword')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerResponseTransferMock);

        $this->customerResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccess')
            ->willReturn(false);

        $this->restApiErrorMock->expects(static::atLeastOnce())
            ->method('processCustomerErrorOnPasswordReset')
            ->with($this->restResponseMock, $this->customerResponseTransferMock)
            ->willReturn($this->restResponseMock);

        $this->restResponseMock->expects(static::never())
            ->method('setStatus');

        $this->customerPasswordWriter->restorePassword($this->restCustomerRestorePasswordAttributesTransferMock);
    }
}
