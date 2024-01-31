<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Plugin\GlueApplication;

use Codeception\Test\Unit;
use FondOfKudu\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiFactory;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Expander\PromotionItemByQuoteResourceRelationshipExpander;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiConfig;
use Spryker\Glue\DiscountPromotionsRestApi\Processor\Expander\PromotionItemByQuoteResourceRelationshipExpanderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResource;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequest;

class PromotionItemByQuoteTransferResourceRelationshipPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResource
     */
    protected MockObject|RestResource $restResourceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequest
     */
    protected MockObject|RestRequest $restRequestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiFactory
     */
    protected MockObject|DiscountPromotionsRestApiFactory $discountPromotionsRestApiFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\DiscountPromotionsRestApi\Processor\Expander\PromotionItemByQuoteResourceRelationshipExpanderInterface
     */
    protected MockObject|PromotionItemByQuoteResourceRelationshipExpanderInterface $promotionItemByQuoteResourceRelationshipExpanderMock;

    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\Plugin\GlueApplication\PromotionItemByQuoteTransferResourceRelationshipPlugin
     */
    protected PromotionItemByQuoteTransferResourceRelationshipPlugin $plugin;

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

        $this->discountPromotionsRestApiFactoryMock = $this->getMockBuilder(DiscountPromotionsRestApiFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->promotionItemByQuoteResourceRelationshipExpanderMock = $this->getMockBuilder(PromotionItemByQuoteResourceRelationshipExpander::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new PromotionItemByQuoteTransferResourceRelationshipPlugin();
        $this->plugin->setFactory($this->discountPromotionsRestApiFactoryMock);
    }

    /**
     * @return void
     */
    public function testAddResourceRelationships(): void
    {
        $this->discountPromotionsRestApiFactoryMock->expects(static::atLeastOnce())
            ->method('createPromotionItemByQuoteResourceRelationshipExpander')
            ->willReturn($this->promotionItemByQuoteResourceRelationshipExpanderMock);

        $this->promotionItemByQuoteResourceRelationshipExpanderMock->expects(static::atLeastOnce())
            ->method('addResourceRelationships')
            ->with([$this->restResourceMock], $this->restRequestMock);

        $this->plugin->addResourceRelationships([$this->restResourceMock], $this->restRequestMock);
    }

    /**
     * @return void
     */
    public function testGetRelationshipResourceType(): void
    {
        static::assertEquals(
            DiscountPromotionsRestApiConfig::RESOURCE_PROMOTIONAL_ITEMS,
            $this->plugin->getRelationshipResourceType(),
        );
    }
}
