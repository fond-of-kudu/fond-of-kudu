<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector\Controller;

use Codeception\Test\Unit;
use FondOfKudu\Glue\CustomersRestApiConnector\CustomersRestApiConnectorFactory;
use FondOfKudu\Glue\CustomersRestApiConnector\Processor\Customers\CustomerPasswordUpdatedProcessor;
use Generated\Shared\Transfer\RestCustomerPasswordUpdatedAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequest;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CustomerPasswordUpdatedResourceControllerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected MockObject|RestRequestInterface $restRequestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCustomerPasswordUpdatedAttributesTransfer
     */
    protected MockObject|RestCustomerPasswordUpdatedAttributesTransfer $restCustomerPasswordUpdatedAttributesTransfer;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Glue\CustomersRestApiConnector\CustomersRestApiConnectorFactory
     */
    protected MockObject|CustomersRestApiConnectorFactory $customersRestApiConnectorFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Glue\CustomersRestApiConnector\Processor\Customers\CustomerPasswordUpdatedProcessor
     */
    protected MockObject|CustomerPasswordUpdatedProcessor $customerPasswordUpdatedProcessorMock;

    /**
     * @var \FondOfKudu\Glue\CustomersRestApiConnector\Controller\CustomerPasswordUpdatedResourceController
     */
    protected CustomerPasswordUpdatedResourceController $customerPasswordUpdatedResourceController;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->restRequestMock = $this->createMock(RestRequest::class);
        $this->restCustomerPasswordUpdatedAttributesTransfer = $this->createMock(RestCustomerPasswordUpdatedAttributesTransfer::class);
        $this->customersRestApiConnectorFactoryMock = $this->createMock(CustomersRestApiConnectorFactory::class);
        $this->customerPasswordUpdatedProcessorMock = $this->createMock(CustomerPasswordUpdatedProcessor::class);
        $this->customerPasswordUpdatedResourceController = new class ($this->customersRestApiConnectorFactoryMock) extends CustomerPasswordUpdatedResourceController {
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
    public function testPostAction(): void
    {
        $this->customersRestApiConnectorFactoryMock->expects(static::once())
            ->method('createCustomerPasswordUpdatedProcessor')
            ->willReturn($this->customerPasswordUpdatedProcessorMock);

        $this->customerPasswordUpdatedProcessorMock->expects(static::once())
            ->method('passwordUpdated')
            ->with($this->restCustomerPasswordUpdatedAttributesTransfer);

        $this->customerPasswordUpdatedResourceController->postAction(
            $this->restRequestMock,
            $this->restCustomerPasswordUpdatedAttributesTransfer,
        );
    }
}
