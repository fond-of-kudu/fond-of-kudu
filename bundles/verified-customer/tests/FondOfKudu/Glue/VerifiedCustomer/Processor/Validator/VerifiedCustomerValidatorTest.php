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
     * @return void
     */
    protected function _before(): void
    {
        $this->requestMock = $this->makeEmpty(RestRequest::class);
        $this->customerClientMock = $this->makeEmpty(VerifiedCustomerToCustomerInterface::class);
        $this->validator = new VerifiedCustomerValidator($this->customerClientMock);
    }

    /**
     * @return void
     */
    public function testIsVerifiedReturnsNullWhenResourceIsUnprotected(): void
    {
        $this->requestMock->method('getRestUser')->willReturn(
            (new RestUserTransfer())->setNaturalIdentifier('customer_reference'),
        );

        $result = $this->validator->isVerified($this->requestMock);

        $this->assertNull($result);
    }

    /**
     * @return void
     */
    public function testIsVerifiedReturnsNullWhenRestUserIsNull(): void
    {
        $this->requestMock->method('getRestUser')->willReturn(null);
        $result = $this->validator->isVerified($this->requestMock);

        $this->assertNull($result);
    }

    /**
     * @return void
     */
    public function testIsVerifiedReturnsErrorCollectionWhenCustomerNotVerified(): void
    {
        $this->requestMock->method('findParentResourceByType')->willReturn(new RestResource('customers', 'customer_reference'));
        $this->requestMock->method('getRestUser')->willReturn(
            (new RestUserTransfer())->setNaturalIdentifier('customer_reference'),
        );

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
        $this->requestMock->method('findParentResourceByType')->willReturn(new RestResource('customers', 'customer_reference'));
        $this->requestMock->method('getRestUser')->willReturn(
            (new RestUserTransfer())->setNaturalIdentifier('customer_reference'),
        );

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
