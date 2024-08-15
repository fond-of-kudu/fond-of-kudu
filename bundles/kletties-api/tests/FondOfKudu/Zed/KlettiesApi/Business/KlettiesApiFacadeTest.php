<?php

namespace FondOfKudu\Zed\KlettiesApi\Business;

use Codeception\Test\Unit;
use FondOfKudu\Zed\KlettiesApi\Business\Model\KlettiesOrderApi;
use FondOfKudu\Zed\KlettiesApi\Business\Model\Validator\KlettiesApiValidator;
use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

class KlettiesApiFacadeTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Business\KlettiesApiFacadeInterface
     */
    protected $facade;

    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Business\KlettiesApiBusinessFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $factoryMock;

    /**
     * @var \Generated\Shared\Transfer\ApiItemTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $apiItemTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ApiCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $apiCollectionTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ApiDataTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $apiDataTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ApiRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $apiRequestTransferMock;

    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Business\Model\KlettiesOrderApiInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $klettiesApiMock;

    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Business\Model\Validator\KlettiesApiValidatorInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $klettiesApiValidatorMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->apiItemTransferMock = $this->getMockBuilder(ApiItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factoryMock = $this->getMockBuilder(KlettiesApiBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiCollectionTransferMock = $this->getMockBuilder(ApiCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiDataTransferMock = $this->getMockBuilder(ApiDataTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiRequestTransferMock = $this->getMockBuilder(ApiRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->klettiesApiMock = $this->getMockBuilder(KlettiesOrderApi::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->klettiesApiValidatorMock = $this->getMockBuilder(KlettiesApiValidator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new class ($this->factoryMock) extends KlettiesApiFacade {
            /**
             * @var \FondOfKudu\Zed\KlettiesApi\Business\KlettiesApiBusinessFactory
             */
            public $factory;

            /**
             *  constructor.
             *
             * @param \FondOfKudu\Zed\KlettiesApi\Business\KlettiesApiBusinessFactory $klettiesFactory
             */
            public function __construct(KlettiesApiBusinessFactory $klettiesFactory)
            {
                $this->factory = $klettiesFactory;
            }

            /**
             * @return \Spryker\Zed\Kernel\Business\AbstractBusinessFactory|\FondOfKudu\Zed\KlettiesApi\Business\KlettiesApiBusinessFactory
             */
            protected function getFactory(): AbstractBusinessFactory
            {
                return $this->factory;
            }
        };
    }

    /**
     * @return void
     */
    public function testUpdateKlettiesOrder(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())->method('createKlettiesApi')->willReturn($this->klettiesApiMock);
        $this->klettiesApiMock->expects(static::atLeastOnce())->method('update')->willReturn($this->apiItemTransferMock);

        static::assertEquals(
            $this->apiItemTransferMock,
            $this->facade->updateKlettiesOrder(1, $this->apiDataTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testFindKlettiesOrder(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())->method('createKlettiesApi')->willReturn($this->klettiesApiMock);
        $this->klettiesApiMock->expects(static::atLeastOnce())->method('find')->willReturn($this->apiCollectionTransferMock);

        static::assertEquals(
            $this->apiCollectionTransferMock,
            $this->facade->findKlettiesOrder($this->apiRequestTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testValidate(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())->method('createKlettiesApiValidator')->willReturn($this->klettiesApiValidatorMock);
        $this->klettiesApiValidatorMock->expects(static::atLeastOnce())->method('validate')->with($this->apiRequestTransferMock)->willReturn([]);

        static::assertEquals(
            [],
            $this->facade->validate($this->apiRequestTransferMock),
        );
    }
}
