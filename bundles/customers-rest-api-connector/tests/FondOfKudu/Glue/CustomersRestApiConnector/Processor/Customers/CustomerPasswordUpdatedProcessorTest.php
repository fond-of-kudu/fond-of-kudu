<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector\Processor\Customers;

use Codeception\Test\Unit;
use FondOfKudu\Glue\CustomersRestApiConnector\CustomersRestApiConnectorConfig;
use FondOfKudu\Glue\CustomersRestApiConnector\Dependency\Client\CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientBridge;
use FondOfKudu\Glue\CustomersRestApiConnector\Dependency\Client\CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientInterface;
use FondOfKudu\Glue\CustomersRestApiConnector\Processor\Mapper\CustomerPasswordUpdatedResourceMapper;
use FondOfKudu\Glue\CustomersRestApiConnector\Processor\Mapper\CustomerPasswordUpdatedResourceMapperInterface;
use FondOfKudu\Glue\CustomersRestApiConnector\Processor\Mapper\CustomerPasswordUpdatedRestResponseMapper;
use FondOfKudu\Glue\CustomersRestApiConnector\Processor\Mapper\CustomerPasswordUpdatedRestResponseMapperInterface;
use FondOfKudu\Glue\CustomersRestApiConnector\Processor\Validation\RestApiError;
use FondOfKudu\Glue\CustomersRestApiConnector\Processor\Validation\RestApiErrorInterface;
use Generated\Shared\Transfer\CustomerPasswordUpdatedResponseTransfer;
use Generated\Shared\Transfer\CustomerPasswordUpdatedRestResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCustomerPasswordUpdatedAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResource;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilder;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponse;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;

class CustomerPasswordUpdatedProcessorTest extends Unit
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
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Glue\CustomersRestApiConnector\Processor\Mapper\CustomerPasswordUpdatedResourceMapperInterface
     */
    protected MockObject|CustomerPasswordUpdatedResourceMapperInterface $customerPasswordUpdatedResourceMapperMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Glue\CustomersRestApiConnector\Processor\Mapper\CustomerPasswordUpdatedRestResponseMapperInterface
     */
    protected MockObject|CustomerPasswordUpdatedRestResponseMapperInterface $customerPasswordUpdatedRestResponseMapperMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Glue\CustomersRestApiConnector\Processor\Validation\RestApiErrorInterface
     */
    protected MockObject|RestApiErrorInterface $restApiErrorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCustomerPasswordUpdatedAttributesTransfer
     */
    protected MockObject|RestCustomerPasswordUpdatedAttributesTransfer $restCustomerPasswordUpdatedAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerPasswordUpdatedResponseTransfer
     */
    protected MockObject|CustomerPasswordUpdatedResponseTransfer $customerPasswordUpdatedResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerPasswordUpdatedRestResponseTransfer
     */
    protected MockObject|CustomerPasswordUpdatedRestResponseTransfer $customerPasswordUpdatedRestResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected MockObject|RestResourceInterface $restResourceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected MockObject|CustomerTransfer $customerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected MockObject|RestResponseInterface $restResponseMock;

    /**
     * @var \FondOfKudu\Glue\CustomersRestApiConnector\Processor\Customers\CustomerPasswordUpdatedProcessorInterface
     */
    protected CustomerPasswordUpdatedProcessorInterface $customerPasswordUpdatedProcessor;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->customerPasswordUpdateAtConnectorClientMock = $this->createMock(CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientBridge::class);
        $this->restResourceBuilderMock = $this->createMock(RestResourceBuilder::class);
        $this->customerPasswordUpdatedResourceMapperMock = $this->createMock(CustomerPasswordUpdatedResourceMapper::class);
        $this->customerPasswordUpdatedRestResponseMapperMock = $this->createMock(CustomerPasswordUpdatedRestResponseMapper::class);
        $this->restApiErrorMock = $this->createMock(RestApiError::class);
        $this->customerTransferMock = $this->createMock(CustomerTransfer::class);
        $this->customerPasswordUpdatedResponseTransferMock = $this->createMock(CustomerPasswordUpdatedResponseTransfer::class);
        $this->customerPasswordUpdatedRestResponseTransferMock = $this->createMock(CustomerPasswordUpdatedRestResponseTransfer::class);
        $this->restResourceMock = $this->createMock(RestResource::class);
        $this->restResponseMock = $this->createMock(RestResponse::class);
        $this->restCustomerPasswordUpdatedAttributesTransferMock = $this->createMock(RestCustomerPasswordUpdatedAttributesTransfer::class);
        $this->customerPasswordUpdatedProcessor = new CustomerPasswordUpdatedProcessor(
            $this->customerPasswordUpdateAtConnectorClientMock,
            $this->restResourceBuilderMock,
            $this->customerPasswordUpdatedResourceMapperMock,
            $this->customerPasswordUpdatedRestResponseMapperMock,
            $this->restApiErrorMock,
        );
    }

    /**
     * @return void
     */
    public function testPasswordUpdatedSuccess(): void
    {
        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->customerPasswordUpdatedResourceMapperMock->expects(static::atLeastOnce())
            ->method('mapRestCustomerPasswordUpdatedAttributesTransferToCustomerTransfer')
            ->with($this->restCustomerPasswordUpdatedAttributesTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->customerPasswordUpdateAtConnectorClientMock->expects(static::atLeastOnce())
            ->method('passwordUpdated')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerPasswordUpdatedResponseTransferMock);

        $this->customerPasswordUpdatedResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccess')
            ->willReturn(true);

        $this->customerPasswordUpdatedRestResponseMapperMock->expects(static::atLeastOnce())
            ->method('mapCustomerPasswordUpdatedRestResponseFromCustomerPasswordUpdatedResponse')
            ->with($this->customerPasswordUpdatedResponseTransferMock)
            ->willReturn($this->customerPasswordUpdatedRestResponseTransferMock);

        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResource')
            ->with(CustomersRestApiConnectorConfig::RESOURCE_CUSTOMER_PASSWORD_UPDATED, null, $this->customerPasswordUpdatedRestResponseTransferMock)
            ->willReturn($this->restResourceMock);

        $this->customerPasswordUpdatedProcessor->passwordUpdated($this->restCustomerPasswordUpdatedAttributesTransferMock);
    }

    /**
     * @return void
     */
    public function testPasswordUpdatedFailed(): void
    {
        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->customerPasswordUpdatedResourceMapperMock->expects(static::atLeastOnce())
            ->method('mapRestCustomerPasswordUpdatedAttributesTransferToCustomerTransfer')
            ->with($this->restCustomerPasswordUpdatedAttributesTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->customerPasswordUpdateAtConnectorClientMock->expects(static::atLeastOnce())
            ->method('passwordUpdated')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerPasswordUpdatedResponseTransferMock);

        $this->customerPasswordUpdatedResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccess')
            ->willReturn(false);

        $this->restApiErrorMock->expects(static::atLeastOnce())
            ->method('addPasswordUpdatedError')
            ->with($this->restResponseMock)
            ->willReturn($this->restResponseMock);

        $this->customerPasswordUpdatedRestResponseMapperMock->expects(static::never())
            ->method('mapCustomerPasswordUpdatedRestResponseFromCustomerPasswordUpdatedResponse')
            ->with($this->customerPasswordUpdatedResponseTransferMock);

        $this->customerPasswordUpdatedProcessor->passwordUpdated($this->restCustomerPasswordUpdatedAttributesTransferMock);
    }

    /**
     * @return void
     */
    public function testPasswordUpdatedAccountNotExists(): void
    {
        $this->restResourceBuilderMock->expects(static::atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseMock);

        $this->customerPasswordUpdatedResourceMapperMock->expects(static::atLeastOnce())
            ->method('mapRestCustomerPasswordUpdatedAttributesTransferToCustomerTransfer')
            ->with($this->restCustomerPasswordUpdatedAttributesTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->customerPasswordUpdateAtConnectorClientMock->expects(static::atLeastOnce())
            ->method('passwordUpdated')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerPasswordUpdatedResponseTransferMock);

        $this->customerPasswordUpdatedResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccess')
            ->willReturn(true);

        $this->customerPasswordUpdatedRestResponseMapperMock->expects(static::atLeastOnce())
            ->method('mapCustomerPasswordUpdatedRestResponseFromCustomerPasswordUpdatedResponse')
            ->with($this->customerPasswordUpdatedResponseTransferMock)
            ->willReturn($this->customerPasswordUpdatedRestResponseTransferMock);

        $this->customerPasswordUpdatedRestResponseTransferMock->setAccountExists(false);

        $this->customerPasswordUpdatedProcessor->passwordUpdated($this->restCustomerPasswordUpdatedAttributesTransferMock);
    }
}
