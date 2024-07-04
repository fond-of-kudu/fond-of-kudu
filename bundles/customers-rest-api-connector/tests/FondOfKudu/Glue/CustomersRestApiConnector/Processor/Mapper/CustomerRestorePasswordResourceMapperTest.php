<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector\Processor\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\RestCustomerRestorePasswordAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CustomerRestorePasswordResourceMapperTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCustomerRestorePasswordAttributesTransfer
     */
    protected MockObject|RestCustomerRestorePasswordAttributesTransfer $restCustomerRestorePasswordAttributesTransferMock;

    /**
     * @var \FondOfKudu\Glue\CustomersRestApiConnector\Processor\Mapper\CustomerRestorePasswordResourceMapperInterface
     */
    protected CustomerRestorePasswordResourceMapperInterface $customerRestorePasswordResourceMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->restCustomerRestorePasswordAttributesTransferMock = $this->createMock(RestCustomerRestorePasswordAttributesTransfer::class);
        $this->customerRestorePasswordResourceMapper = new CustomerRestorePasswordResourceMapper();
    }

    /**
     * @return void
     */
    public function testMapCustomerRestorePasswordAttributesToCustomerTransfer(): void
    {
        $this->restCustomerRestorePasswordAttributesTransferMock->expects(static::once())
            ->method('toArray')
            ->willReturn([]);

        $this->customerRestorePasswordResourceMapper
            ->mapCustomerRestorePasswordAttributesToCustomerTransfer(
                $this->restCustomerRestorePasswordAttributesTransferMock,
            );
    }
}
