<?php

namespace FondOfKudu\Zed\ProductsAttributesCartConnector\Persistence\Mapper;

use Codeception\Test\Unit;
use FondOfKudu\Zed\ProductAttributesCartConnector\Persistence\Mapper\AttributesMapper;
use Orm\Zed\Product\Persistence\SpyProductAbstract;
use Propel\Runtime\Collection\ObjectCollection;
use Spryker\Service\UtilEncoding\UtilEncodingServiceInterface;

class AttributesMapperTest extends Unit
{
    /**
     * @return void
     */
    public function testMapEntityToTransfer(): void
    {
        $encodingMock = $this->getMockBuilder(UtilEncodingServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $entities = new ObjectCollection();
        $product = (new SpyProductAbstract())
            ->setIdProductAbstract(1)
            ->setAttributes('{"key": "value"}');

        $entities->setData([$product]);

        $encodingMock->expects($this->once())
            ->method('decodeJson')
            ->willReturn(['key' => 'value']);

        $attributes = (new AttributesMapper($encodingMock))->mapEntityToTransfer($entities);

        $this->assertIsArray($attributes);
        $this->assertArrayHasKey('key', $attributes[1]);
    }
}
