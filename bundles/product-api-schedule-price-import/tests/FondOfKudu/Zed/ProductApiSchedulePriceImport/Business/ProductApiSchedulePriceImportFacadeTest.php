<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business;

use Codeception\Test\Unit;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SalePriceProductAbstractHandler;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ProductApiSchedulePriceImportFacadeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductAbstractTransfer
     */
    protected MockObject|ProductAbstractTransfer $productAbstractTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\ProductApiSchedulePriceImportBusinessFactory
     */
    protected MockObject|ProductApiSchedulePriceImportBusinessFactory $productApiSchedulePriceImportBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SalePriceProductAbstractHandler
     */
    protected MockObject|SalePriceProductAbstractHandler $salePriceProductAbstractHandlerMock;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\ProductApiSchedulePriceImportFacadeInterface
     */
    protected ProductApiSchedulePriceImportFacadeInterface $apiSchedulePriceImportFacade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->productAbstractTransferMock = $this->createMock(ProductAbstractTransfer::class);
        $this->productApiSchedulePriceImportBusinessFactoryMock = $this->createMock(ProductApiSchedulePriceImportBusinessFactory::class);
        $this->salePriceProductAbstractHandlerMock = $this->createMock(SalePriceProductAbstractHandler::class);

        $this->apiSchedulePriceImportFacade = new ProductApiSchedulePriceImportFacade();
        $this->apiSchedulePriceImportFacade->setFactory($this->productApiSchedulePriceImportBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testOnCreateProductAbstract(): void
    {
        $this->productApiSchedulePriceImportBusinessFactoryMock->expects(static::once())
            ->method('createSalePriceProductAbstractHandler')
            ->willReturn($this->salePriceProductAbstractHandlerMock);

        $this->salePriceProductAbstractHandlerMock->expects(static::once())
            ->method('handle')
            ->with($this->productAbstractTransferMock)
            ->willReturn($this->productAbstractTransferMock);

        $productAbstractTransfer = $this->apiSchedulePriceImportFacade
            ->onUpdateProductAbstract($this->productAbstractTransferMock);

        static::assertEquals($productAbstractTransfer, $this->productAbstractTransferMock);
    }

    /**
     * @return void
     */
    public function testOnUpdateProductAbstract(): void
    {
        $this->productApiSchedulePriceImportBusinessFactoryMock->expects(static::once())
            ->method('createSalePriceProductAbstractHandler')
            ->willReturn($this->salePriceProductAbstractHandlerMock);

        $this->salePriceProductAbstractHandlerMock->expects(static::once())
            ->method('handle')
            ->with($this->productAbstractTransferMock)
            ->willReturn($this->productAbstractTransferMock);

        $productAbstractTransfer = $this->apiSchedulePriceImportFacade
            ->onUpdateProductAbstract($this->productAbstractTransferMock);

        static::assertEquals($productAbstractTransfer, $this->productAbstractTransferMock);
    }
}
