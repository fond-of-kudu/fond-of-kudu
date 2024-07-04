<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector\Processor\Validation;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\CustomerErrorTransfer;
use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponse;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;

class RestApiErrorTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected MockObject|RestResponseInterface $restResponseMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestErrorMessageTransfer
     */
    protected MockObject|RestErrorMessageTransfer $restErrorMessageTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerResponseTransfer
     */
    protected MockObject|CustomerResponseTransfer $customerResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerErrorTransfer
     */
    protected MockObject|CustomerErrorTransfer $customerErrorTransferMock;

    /**
     * @var \FondOfKudu\Glue\CustomersRestApiConnector\Processor\Validation\RestApiErrorInterface
     */
    protected RestApiErrorInterface $restApiError;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->restResponseMock = $this->createMock(RestResponse::class);
        $this->restErrorMessageTransferMock = $this->createMock(RestErrorMessageTransfer::class);
        $this->customerResponseTransferMock = $this->createMock(CustomerResponseTransfer::class);
        $this->customerErrorTransferMock = $this->createMock(CustomerErrorTransfer::class);
        $this->restApiError = new RestApiError();
    }

    /**
     * @return void
     */
    public function testAddPasswordsDoNotMatchError(): void
    {
        $this->restResponseMock->expects(static::atLeastOnce())
            ->method('addError')
            ->willReturnSelf();

         $this->restApiError->addPasswordsDoNotMatchError(
             $this->restResponseMock,
             'password1',
             'password2',
         );
    }

    /**
     * @return void
     */
    public function testProcessCustomerErrorOnPasswordResetSuccess(): void
    {
        $this->customerResponseTransferMock->expects(static::atLeastOnce())
            ->method('getErrors')
            ->willReturn(new ArrayObject());

        $this->restResponseMock->expects(static::atLeastOnce())
            ->method('getErrors')
            ->willReturn([]);

        $this->restApiError->processCustomerErrorOnPasswordReset(
            $this->restResponseMock,
            $this->customerResponseTransferMock,
        );
    }

    /**
     * @return void
     */
    public function testProcessCustomerErrorOnPasswordResetFailedCustomerEmailInvalid(): void
    {
        $this->customerResponseTransferMock->expects(static::atLeastOnce())
            ->method('getErrors')
            ->willReturn(new ArrayObject([$this->customerErrorTransferMock]));

        $this->customerErrorTransferMock->expects(static::atLeastOnce())
            ->method('getMessage')
            ->willReturn(RestApiError::ERROR_CUSTOMER_PASSWORD_INVALID);

        $this->restResponseMock->expects(static::atLeastOnce())
            ->method('addError')
            ->willReturnSelf();

        $this->restResponseMock->expects(static::atLeastOnce())
            ->method('getErrors')
            ->willReturn([$this->restErrorMessageTransferMock]);

        $this->restApiError->processCustomerErrorOnPasswordReset(
            $this->restResponseMock,
            $this->customerResponseTransferMock,
        );
    }
}
