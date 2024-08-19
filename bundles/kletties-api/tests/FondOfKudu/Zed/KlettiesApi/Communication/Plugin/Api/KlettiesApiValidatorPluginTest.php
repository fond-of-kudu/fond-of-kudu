<?php

namespace FondOfKudu\Zed\KlettiesApi\Communication\Plugin\Api;

use Codeception\Test\Unit;
use FondOfKudu\Zed\KlettiesApi\Business\KlettiesApiFacade;
use FondOfKudu\Zed\KlettiesApi\Business\KlettiesApiFacadeInterface;
use Generated\Shared\Transfer\ApiRequestTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class KlettiesApiValidatorPluginTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Communication\Plugin\Api\KlettiesApiValidatorPlugin
     */
    protected KlettiesApiValidatorPlugin $plugin;

    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Business\KlettiesApiFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected KlettiesApiFacadeInterface|MockObject $facadeMock;

    /**
     * @var \Generated\Shared\Transfer\ApiRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ApiRequestTransfer|MockObject $apiRequestTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->facadeMock = $this->getMockBuilder(KlettiesApiFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiRequestTransferMock = $this->getMockBuilder(ApiRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new KlettiesApiValidatorPlugin();
        $this->plugin->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testValidate(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('validate')
            ->willReturn([]);

        static::assertEquals(
            [],
            $this->plugin->validate($this->apiRequestTransferMock),
        );
    }
}
