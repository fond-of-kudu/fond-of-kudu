<?php

namespace FondOfKudu\Zed\ProductsAttributesCartConnector\Business\Expander;

use Codeception\Test\Unit;

class ProductAttributesExpanderTest extends Unit
{
    /**
     * @return void
     */
    public function testExpandItems()
    {
        $repositoryMock = $this->getMockBuilder(ProductAttributesCartConnectorRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $cartChangeTransfer = new CartChangeTransfer();
        $itemTransfer = new ItemTransfer();
        $itemTransfer->setIdProductAbstract(1);
        $cartChangeTransfer->setItems([$itemTransfer]);

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
