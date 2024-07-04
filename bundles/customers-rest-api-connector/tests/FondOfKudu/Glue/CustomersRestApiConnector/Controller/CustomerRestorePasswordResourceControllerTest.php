<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector\Controller;

use Codeception\Test\Unit;
use FondOfKudu\Glue\CustomersRestApiConnector\CustomersRestApiConnectorFactory;
use FondOfKudu\Glue\CustomersRestApiConnector\Processor\Customers\CustomerPasswordWriter;
use FondOfKudu\Glue\CustomersRestApiConnector\Processor\Customers\CustomerPasswordWriterInterface;
use Generated\Shared\Transfer\RestCustomerRestorePasswordAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequest;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CustomerRestorePasswordResourceControllerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected MockObject|RestRequestInterface $restRequestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCustomerRestorePasswordAttributesTransfer
     */
    protected MockObject|RestCustomerRestorePasswordAttributesTransfer $restCustomerRestorePasswordAttributesTransfer;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Glue\CustomersRestApiConnector\CustomersRestApiConnectorFactory
     */
    protected MockObject|CustomersRestApiConnectorFactory $customersRestApiConnectorFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Glue\CustomersRestApiConnector\Processor\Customers\CustomerPasswordWriterInterface
     */
    protected MockObject|CustomerPasswordWriterInterface $customerPasswordWriterMock;

    /**
     * @var \FondOfKudu\Glue\CustomersRestApiConnector\Controller\CustomerRestorePasswordResourceController
     */
    protected CustomerRestorePasswordResourceController $customerRestorePasswordResourceController;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->restRequestMock = $this->createMock(RestRequest::class);
        $this->restCustomerRestorePasswordAttributesTransfer = $this->createMock(RestCustomerRestorePasswordAttributesTransfer::class);
        $this->customersRestApiConnectorFactoryMock = $this->createMock(CustomersRestApiConnectorFactory::class);
        $this->customerPasswordWriterMock = $this->createMock(CustomerPasswordWriter::class);
        $this->customerRestorePasswordResourceController = new class ($this->customersRestApiConnectorFactoryMock) extends CustomerRestorePasswordResourceController {
            /**
             * @var \FondOfKudu\Glue\CustomersRestApiConnector\CustomersRestApiConnectorFactory
             */
            protected CustomersRestApiConnectorFactory $customersRestApiConnectorFactory;

            /**
             * @param \FondOfKudu\Glue\CustomersRestApiConnector\CustomersRestApiConnectorFactory $customersRestApiConnectorFactory
             */
            public function __construct(CustomersRestApiConnectorFactory $customersRestApiConnectorFactory)
            {
                $this->customersRestApiConnectorFactory = $customersRestApiConnectorFactory;
            }

            /**
             * @return \FondOfKudu\Glue\CustomersRestApiConnector\CustomersRestApiConnectorFactory
             */
            public function getFactory(): CustomersRestApiConnectorFactory
            {
                return $this->customersRestApiConnectorFactory;
            }
        };
    }

    /**
     * @return void
     */
    public function testPatchAction(): void
    {
        $this->customersRestApiConnectorFactoryMock->expects(static::once())
            ->method('createCustomerPasswordWriter')
            ->willReturn($this->customerPasswordWriterMock);

        $this->customerPasswordWriterMock->expects(static::once())
            ->method('restorePassword')
            ->with($this->restCustomerRestorePasswordAttributesTransfer);

        $this->customerRestorePasswordResourceController->patchAction(
            $this->restRequestMock,
            $this->restCustomerRestorePasswordAttributesTransfer,
        );
    }
}
