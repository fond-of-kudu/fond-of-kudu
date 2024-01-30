<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Expander;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\PromotionItemMapper;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\PromotionItemMapperInterface;
use Generated\Shared\Transfer\PromotionItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestPromotionalItemsAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResource;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilder;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\Metadata;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequest;

class PromotionItemByQuoteResourceRelationshipExpanderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\PromotionItemMapperInterface
     */
    protected MockObject|PromotionItemMapperInterface $promotionItemMapperMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResource
     */
    protected MockObject|RestResource $restResourceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequest
     */
    protected MockObject|RestRequest $restRequestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\Metadata
     */
    protected MockObject|Metadata $metadataMock;

    protected MockObject|RestResourceBuilderInterface $restResourceBuilderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestPromotionalItemsAttributesTransfer
     */
    protected MockObject|RestPromotionalItemsAttributesTransfer $restPromotionalItemsAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PromotionItemTransfer
     */
    protected MockObject|PromotionItemTransfer $promotionItemTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected MockObject|QuoteTransfer $quoteTransferMock;

    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Expander\PromotionItemByQuoteResourceRelationshipExpander
     */
    protected PromotionItemByQuoteResourceRelationshipExpander $expander;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->restResourceMock = $this->getMockBuilder(RestResource::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock = $this->getMockBuilder(RestRequest::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceBuilderMock = $this->getMockBuilder(RestResourceBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->promotionItemMapperMock = $this->getMockBuilder(PromotionItemMapper::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restPromotionalItemsAttributesTransferMock = $this->getMockBuilder(RestPromotionalItemsAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->promotionItemTransferMock = $this->getMockBuilder(PromotionItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->metadataMock = $this->getMockBuilder(Metadata::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expander = new PromotionItemByQuoteResourceRelationshipExpander(
            $this->restResourceBuilderMock,
            $this->promotionItemMapperMock,
        );
    }

    /**
     * @return void
     */
    public function testAddResourceRelationships(): void
    {
        $this->restRequestMock->expects(static::atLeastOnce())
            ->method('getMetadata')
            ->willReturn($this->metadataMock);

        $this->metadataMock->expects(static::atLeastOnce())
            ->method('getLocale')
            ->willReturn('de_DE');

        $this->restResourceMock->expects(static::atLeastOnce())
            ->method('getPayload')
            ->willReturn($this->quoteTransferMock);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getPromotionItems')
            ->willReturn(new ArrayObject([$this->promotionItemTransferMock]));

        $this->promotionItemTransferMock->expects(static::atLeastOnce())
            ->method('getUuid')
            ->willReturn('abcd');

        $this->promotionItemMapperMock->expects(static::atLeastOnce())
            ->method('mapPromotedProductsToRestPromotionalItemsAttributesTransfer')
            ->willReturn($this->restPromotionalItemsAttributesTransferMock);

        $this->expander->addResourceRelationships([$this->restResourceMock], $this->restRequestMock);
    }
}
