<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector\Processor\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CustomerPasswordUpdatedResponseTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CustomerPasswordUpdatedRestResponseMapperTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerPasswordUpdatedResponseTransfer
     */
    protected MockObject|CustomerPasswordUpdatedResponseTransfer $customerPasswordUpdatedResponseTransferMock;

    /**
     * @var \FondOfKudu\Glue\CustomersRestApiConnector\Processor\Mapper\CustomerPasswordUpdatedRestResponseMapperInterface
     */
    protected CustomerPasswordUpdatedRestResponseMapperInterface $customerPasswordUpdatedRestResponseMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->customerPasswordUpdatedResponseTransferMock = $this->createMock(CustomerPasswordUpdatedResponseTransfer::class);
        $this->customerPasswordUpdatedRestResponseMapper = new CustomerPasswordUpdatedRestResponseMapper();
    }

    /**
     * @return void
     */
    public function testMapCustomerPasswordUpdatedRestResponseFromCustomerPasswordUpdatedResponse(): void
    {
        $this->customerPasswordUpdatedResponseTransferMock->expects(static::once())
            ->method('toArray')
            ->willReturn([]);

        $this->customerPasswordUpdatedRestResponseMapper
            ->mapCustomerPasswordUpdatedRestResponseFromCustomerPasswordUpdatedResponse(
                $this->customerPasswordUpdatedResponseTransferMock,
            );
    }
}
