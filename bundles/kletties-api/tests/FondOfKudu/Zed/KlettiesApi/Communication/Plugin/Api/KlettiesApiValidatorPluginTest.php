<?php

namespace FondOfKudu\Zed\KlettiesApi\Communication\Plugin\Api;

use Codeception\Test\Unit;
use FondOfKudu\Zed\KlettiesApi\Business\KlettiesApiFacade;
use FondOfKudu\Zed\KlettiesApi\Business\KlettiesApiFacadeInterface;
use Generated\Shared\Transfer\ApiRequestTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

class KlettiesApiValidatorPluginTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Communication\Plugin\Api\KlettiesApiValidatorPlugin
     */
    protected $plugin;

    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Business\KlettiesApiFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $facadeMock;

    /**
     * @var \Generated\Shared\Transfer\ApiRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $apiRequestTransferMock;

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

        $this->plugin = new class ($this->facadeMock) extends KlettiesApiValidatorPlugin {
            /**
             * @var \FondOfKudu\Zed\KlettiesApi\Business\KlettiesApiFacadeInterface
             */
            public $facade;

            /**
             *  constructor.
             *
             * @param \FondOfKudu\Zed\KlettiesApi\Business\KlettiesApiFacadeInterface $klettiesFacade
             */
            public function __construct(KlettiesApiFacadeInterface $klettiesFacade)
            {
                $this->facade = $klettiesFacade;
            }

            /**
             * @return \FondOfKudu\Zed\KlettiesApi\Business\KlettiesApiFacadeInterface|\Spryker\Zed\Kernel\Business\AbstractFacade
             */
            protected function getFacade(): AbstractFacade
            {
                return $this->facade;
            }
        };
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
