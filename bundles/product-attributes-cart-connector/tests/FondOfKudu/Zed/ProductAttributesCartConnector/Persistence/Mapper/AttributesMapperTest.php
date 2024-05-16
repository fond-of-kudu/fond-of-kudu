<?php

namespace FondOfKudu\Zed\ProductsAttributesCartConnector\Persistence\Mapper;

use Codeception\Test\Unit;
use FondOfKudu\Zed\ProductAttributesCartConnector\Persistence\Mapper\AttributesMapper;
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

        $abstractProductEntities = [
            [
                'IdProductAbstract' => 1,
                'Attributes' => '{"key": "value"}',
            ],
        ];

        $encodingMock->expects($this->once())
            ->method('decodeJson')
            ->willReturn(['key' => 'value']);

        $attributes = (new AttributesMapper($encodingMock))->mapEntityToTransfer($abstractProductEntities);

        $this->assertIsArray($attributes);
        $this->assertArrayHasKey('_', $attributes[0]);
        $this->assertArrayHasKey('key', $attributes[0]['_']);
    }
}
