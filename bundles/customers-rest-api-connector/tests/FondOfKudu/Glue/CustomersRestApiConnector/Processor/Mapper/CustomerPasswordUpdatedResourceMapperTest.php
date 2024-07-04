<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector\Processor\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestCustomerPasswordUpdatedAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CustomerPasswordUpdatedResourceMapperTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCustomerPasswordUpdatedAttributesTransfer
     */
    protected MockObject|RestCustomerPasswordUpdatedAttributesTransfer $restCustomerPasswordUpdatedAttributesTransferMock;

    /**
     * @var \FondOfKudu\Glue\CustomersRestApiConnector\Processor\Mapper\CustomerPasswordUpdatedResourceMapperInterface
     */
    protected CustomerPasswordUpdatedResourceMapperInterface $customerPasswordUpdatedResourceMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->restCustomerPasswordUpdatedAttributesTransferMock = $this->createMock(RestCustomerPasswordUpdatedAttributesTransfer::class);
        $this->customerPasswordUpdatedResourceMapper = new CustomerPasswordUpdatedResourceMapper();
    }

    /**
     * @return void
     */
    public function testMapRestCustomerPasswordUpdatedAttributesTransferToCustomerTransfer()
    {
        $this->restCustomerPasswordUpdatedAttributesTransferMock->expects(static::once())
            ->method('toArray')
            ->willReturn([]);

        $this->customerPasswordUpdatedResourceMapper
            ->mapRestCustomerPasswordUpdatedAttributesTransferToCustomerTransfer($this->restCustomerPasswordUpdatedAttributesTransferMock);
    }
}
