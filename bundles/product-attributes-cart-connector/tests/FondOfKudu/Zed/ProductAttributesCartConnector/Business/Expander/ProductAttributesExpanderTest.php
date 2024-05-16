<?php

namespace FondOfKudu\Zed\ProductsAttributesCartConnector\Business\Expander;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfKudu\Zed\ProductAttributesCartConnector\Business\Expander\ProductAttributesExpander;
use FondOfKudu\Zed\ProductAttributesCartConnector\Persistence\ProductAttributesCartConnectorRepository;
use Generated\Shared\Transfer\CartChangeTransfer;
use Generated\Shared\Transfer\ItemTransfer;

class ProductAttributesExpanderTest extends Unit
{
    /**
     * @return void
     */
    public function testExpandItems(): void
    {
        $repositoryMock = $this->getMockBuilder(ProductAttributesCartConnectorRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $cartChangeTransfer = new CartChangeTransfer();
        $itemTransfer = new ItemTransfer();
        $itemTransfer->setIdProductAbstract(1);

        $items = new ArrayObject();
        $items->append($itemTransfer);
        $cartChangeTransfer->setItems($items);

        $repositoryMock->method('getProductAbstractAttributes')
            ->willReturn([
                1 => [
                    '_' => ['key' => 'value'],
                ],
            ]);

        $expander = new ProductAttributesExpander($repositoryMock);
        $expandedTransfer = $expander->expandItems($cartChangeTransfer);

        $this->assertIsArray($expandedTransfer->getItems()[0]->getAbstractAttributes());
        $this->assertArrayHasKey('_', $expandedTransfer->getItems()[0]->getAbstractAttributes());
    }
}
