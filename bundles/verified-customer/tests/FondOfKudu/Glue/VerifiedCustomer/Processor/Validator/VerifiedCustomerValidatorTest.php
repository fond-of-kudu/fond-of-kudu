<?php

namespace FondOfKudu\Glue\VerifiedCustomer\Processor\Validator;

use Codeception\Test\Unit;
use FondOfKudu\Glue\VerifiedCustomer\Dependency\Client\VerifiedCustomerToCustomerInterface;
use FondOfKudu\Glue\VerifiedCustomer\VerifiedCustomerConfig;
use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestErrorCollectionTransfer;
use Generated\Shared\Transfer\RestUserTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResource;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequest;
use Symfony\Component\HttpFoundation\Response;

class VerifiedCustomerValidatorTest extends Unit
{
    /**
     * @var \FondOfKudu\Glue\VerifiedCustomer\Dependency\Client\VerifiedCustomerToCustomerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected VerifiedCustomerToCustomerInterface|MockObject $customerClientMock;

    /**
     * @var \FondOfKudu\Glue\VerifiedCustomer\Processor\Validator\VerifiedCustomerValidator
     */
    protected VerifiedCustomerValidator $validator;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Glue\VerifiedCustomer\VerifiedCustomerConfig
     */
    protected MockObject|VerifiedCustomerConfig $configMock;

    /**
     * @var \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequest|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestRequest|MockObject $requestMock;

    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResource|\PHPUnit\Framework\MockObject\MockObject
     */
    private RestResource|MockObject $restResourceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->restResourceMock = $this->makeEmpty(RestResource::class);
        $this->requestMock = $this->makeEmpty(RestRequest::class);
        $this->configMock = $this->makeEmpty(VerifiedCustomerConfig::class);
        $this->customerClientMock = $this->makeEmpty(VerifiedCustomerToCustomerInterface::class);
        $this->validator = new VerifiedCustomerValidator($this->configMock, $this->customerClientMock);
    }

    /**
     * @return void
     */
    public function testIsVerifiedReturnsNullWhenResourceTypeNotBlocked(): void
    {
        $this->restResourceMock->method('getType')->willReturn('unblocked_resource');
        $this->requestMock->method('getResource')->willReturn($this->restResourceMock);

        $this->configMock->method('getResourcesToBlock')->willReturn(['blocked_resource']);

        $result = $this->validator->isVerified($this->requestMock);

        $this->assertNull($result);
    }

    /**
     * @return void
     */
    public function testIsVerifiedReturnsNullWhenRestUserIsNull(): void
    {
        $this->restResourceMock->method('getType')->willReturn('unblocked_resource');
        $this->requestMock->method('getResource')->willReturn($this->restResourceMock);
        $this->requestMock->method('getRestUser')->willReturn(null);

        $this->configMock->method('getResourcesToBlock')->willReturn(['blocked_resource']);

        $result = $this->validator->isVerified($this->requestMock);

        $this->assertNull($result);
    }

    /**
     * @return void
     */
    public function testIsVerifiedReturnsErrorCollectionWhenCustomerNotVerified(): void
    {
        $this->restResourceMock->method('getType')->willReturn('blocked_resource');
        $this->requestMock->method('getResource')->willReturn($this->restResourceMock);
        $this->requestMock->method('getRestUser')->willReturn(
            (new RestUserTransfer())->setNaturalIdentifier('customer_reference'),
        );

        $this->configMock->method('getResourcesToBlock')->willReturn(['blocked_resource']);

        $customerTransfer = new CustomerTransfer();
        $customerTransfer->setCustomerReference('customer_reference');
        $customerTransfer->setRegistered(null);
        $customerTransfer->setRegistrationKey('some_key');

        $customerResponseTransfer = new CustomerResponseTransfer();
        $customerResponseTransfer->setCustomerTransfer($customerTransfer);

        $this->customerClientMock->method('findCustomerByReference')->willReturn($customerResponseTransfer);

        $result = $this->validator->isVerified($this->requestMock);

        $this->assertInstanceOf(RestErrorCollectionTransfer::class, $result);
        $this->assertCount(1, $result->getRestErrors());
        $this->assertEquals(Response::HTTP_FORBIDDEN, $result->getRestErrors()[0]->getStatus());
        $this->assertEquals(VerifiedCustomerConfig::CUSTOMER_NOT_VERIFIED_ERROR_CODE, $result->getRestErrors()[0]->getCode());
        $this->assertEquals('Customer is not verified.', $result->getRestErrors()[0]->getDetail());
    }

    /**
     * @return void
     */
    public function testIsVerifiedReturnsNullWhenCustomerIsVerified(): void
    {
        $this->restResourceMock->method('getType')->willReturn('blocked_resource');
        $this->requestMock->method('getResource')->willReturn($this->restResourceMock);
        $this->requestMock->method('getRestUser')->willReturn(
            (new RestUserTransfer())->setNaturalIdentifier('customer_reference'),
        );

        $this->configMock->method('getResourcesToBlock')->willReturn(['blocked_resource']);

        $customerTransfer = new CustomerTransfer();
        $customerTransfer->setCustomerReference('customer_reference');
        $customerTransfer->setRegistered('2021-01-01');
        $customerTransfer->setRegistrationKey(null);

        $customerResponseTransfer = new CustomerResponseTransfer();
        $customerResponseTransfer->setCustomerTransfer($customerTransfer);

        $this->customerClientMock->method('findCustomerByReference')->willReturn($customerResponseTransfer);

        $result = $this->validator->isVerified($this->requestMock);

        $this->assertNull($result);
    }
}
