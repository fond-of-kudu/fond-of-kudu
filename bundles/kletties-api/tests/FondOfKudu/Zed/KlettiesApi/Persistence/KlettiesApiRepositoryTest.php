<?php

namespace FondOfKudu\Zed\KlettiesApi\Persistence;

use Codeception\Test\Unit;
use Exception;
use FondOfKudu\Zed\Kletties\Exception\KlettiesOrderNotFoundException;
use FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToApiFacadeBridge;
use FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToKlettiesFacadeBridge;
use FondOfKudu\Zed\KlettiesApi\Dependency\QueryContainer\KlettiesApiToApiQueryBuilderContainerBridge;
use FondOfKudu\Zed\KlettiesApi\Persistence\Propel\Mapper\TransferMapper;
use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiFilterTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;
use Generated\Shared\Transfer\FokKlettiesOrderEntityTransfer;
use Generated\Shared\Transfer\KlettiesOrderTransfer;
use Orm\Zed\Kletties\Persistence\FokKlettiesOrderQuery;
use Propel\Runtime\Collection\ObjectCollection;
use Spryker\Zed\Kernel\Container;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class KlettiesApiRepositoryTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Persistence\KlettiesApiRepositoryInterface
     */
    protected $repository;

    /**
     * @var \Spryker\Zed\Kernel\Container|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $containerMock;

    /**
     * @var \Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $factoryMock;

    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Dependency\QueryContainer\KlettiesApiToApiQueryBuilderContainerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $klettiesQueryBuilderContainerMock;

    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToApiFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $klettiesQueryContainerMock;

    /**
     * @var \Orm\Zed\Kletties\Persistence\FokKlettiesOrderQuery|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $orderQueryMock;

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
     * @var \FondOfKudu\Zed\KlettiesApi\Persistence\Propel\Mapper\TransferMapperInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $transferMapperMock;

    /**
     * @var \Propel\Runtime\Collection\ObjectCollection|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $objectCollectionMock;

    /**
     * @var \Generated\Shared\Transfer\ApiFilterTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $apiFilterTransferMock;

    /**
     * @var \Generated\Shared\Transfer\FokKlettiesOrderEntityTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $orderEntityTransferMock;

    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToKlettiesFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $facadeMock;

    /**
     * @var \Generated\Shared\Transfer\KlettiesOrderTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $orderTransferMock;

    /**
     * @return void
     */
    public function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)->disableOriginalConstructor()->getMock();
        $this->factoryMock = $this->getMockBuilder(KlettiesApiPersistenceFactory::class)->disableOriginalConstructor()->getMock();
        $this->objectCollectionMock = $this->getMockBuilder(ObjectCollection::class)->disableOriginalConstructor()->getMock();
        $this->klettiesQueryBuilderContainerMock = $this->getMockBuilder(KlettiesApiToApiQueryBuilderContainerBridge::class)->disableOriginalConstructor()->getMock();
        $this->klettiesQueryContainerMock = $this->getMockBuilder(KlettiesApiToApiFacadeBridge::class)->disableOriginalConstructor()->getMock();
        $this->orderQueryMock = $this->getMockBuilder(FokKlettiesOrderQuery::class)->disableOriginalConstructor()->getMock();
        $this->apiItemTransferMock = $this->getMockBuilder(ApiItemTransfer::class)
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

        $this->transferMapperMock = $this->getMockBuilder(TransferMapper::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiFilterTransferMock = $this->getMockBuilder(ApiFilterTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderEntityTransferMock = $this->getMockBuilder(FokKlettiesOrderEntityTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facadeMock = $this->getMockBuilder(KlettiesApiToKlettiesFacadeBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderTransferMock = $this->getMockBuilder(KlettiesOrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repository = new KlettiesApiRepository();
        $this->repository->setContainer($this->containerMock);
        $this->repository->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testFind(): void
    {
        $this->factoryMock->expects($this->once())->method('getKlettiesOrderQuery')->willReturn($this->orderQueryMock);
        $this->factoryMock->expects($this->once())->method('getQueryBuilderContainer')->willReturn($this->klettiesQueryBuilderContainerMock);
        $this->factoryMock->expects($this->once())->method('createTransferMapper')->willReturn($this->transferMapperMock);
        $this->factoryMock->expects($this->once())->method('getQueryContainer')->willReturn($this->klettiesQueryContainerMock);
        $this->klettiesQueryBuilderContainerMock->expects($this->once())->method('buildQueryFromRequest')->willReturn($this->orderQueryMock);
        $this->transferMapperMock->expects($this->once())->method('toTransferCollection')->willReturn([]);
        $this->klettiesQueryContainerMock->expects($this->once())->method('createApiCollection')->willReturn($this->apiCollectionTransferMock);
        $this->orderQueryMock->expects($this->once())->method('find')->willReturn($this->objectCollectionMock);
        $this->orderQueryMock->expects($this->once())->method('count')->willReturn(1);
        $this->objectCollectionMock->expects($this->once())->method('getData')->willReturn([]);
        $this->apiCollectionTransferMock->expects($this->once())->method('setPagination');
        $this->apiRequestTransferMock->method('getFilter')->willReturn($this->apiFilterTransferMock);
        $this->apiFilterTransferMock->method('getLimit')->willReturn(1);
        $this->apiFilterTransferMock->method('getOffset')->willReturn(0);

        $this->repository->find($this->apiRequestTransferMock);
    }

    /**
     * @return void
     */
    public function testFindOutOfBoundException(): void
    {
        $this->factoryMock->expects($this->once())->method('getKlettiesOrderQuery')->willReturn($this->orderQueryMock);
        $this->factoryMock->expects($this->once())->method('getQueryBuilderContainer')->willReturn($this->klettiesQueryBuilderContainerMock);
        $this->factoryMock->expects($this->once())->method('createTransferMapper')->willReturn($this->transferMapperMock);
        $this->factoryMock->expects($this->once())->method('getQueryContainer')->willReturn($this->klettiesQueryContainerMock);
        $this->klettiesQueryBuilderContainerMock->expects($this->once())->method('buildQueryFromRequest')->willReturn($this->orderQueryMock);
        $this->transferMapperMock->expects($this->once())->method('toTransferCollection')->willReturn([]);
        $this->klettiesQueryContainerMock->expects($this->once())->method('createApiCollection')->willReturn($this->apiCollectionTransferMock);
        $this->orderQueryMock->expects($this->once())->method('find')->willReturn($this->objectCollectionMock);
        $this->orderQueryMock->expects($this->once())->method('count')->willReturn(1);
        $this->objectCollectionMock->expects($this->once())->method('getData')->willReturn([]);
        $this->apiCollectionTransferMock->expects($this->never())->method('setPagination');
        $this->apiRequestTransferMock->method('getFilter')->willReturn($this->apiFilterTransferMock);
        $this->apiFilterTransferMock->method('getLimit')->willReturn(1);
        $this->apiFilterTransferMock->method('getOffset')->willReturn(1);

        $catch = null;
        try {
            $this->repository->find($this->apiRequestTransferMock);
        } catch (Exception $exception) {
            $catch = $exception;
        }

        $this->assertNotNull($catch);
        $this->assertInstanceOf(NotFoundHttpException::class, $catch);
    }

    /**
     * @return void
     */
    public function testConvert(): void
    {
        $this->factoryMock->expects($this->once())->method('getKlettiesFacade')->willReturn($this->facadeMock);
        $this->factoryMock->expects($this->once())->method('getQueryContainer')->willReturn($this->klettiesQueryContainerMock);
        $this->facadeMock->expects($this->once())->method('findKlettiesOrderById')->willReturn($this->orderTransferMock);
        $this->orderEntityTransferMock->expects($this->once())->method('getIdKlettiesOrder')->willReturn(1);
        $this->orderTransferMock->expects($this->once())->method('getId')->willReturn(1);
        $this->klettiesQueryContainerMock->expects($this->once())->method('createApiItem')->willReturn($this->apiItemTransferMock);

        $this->repository->convert($this->orderEntityTransferMock);
    }

    /**
     * @return void
     */
    public function testConvertThrowsException(): void
    {
        $this->factoryMock->expects($this->once())->method('getKlettiesFacade')->willReturn($this->facadeMock);
        $this->facadeMock->expects($this->once())->method('findKlettiesOrderById')->willReturn(null);
        $this->orderEntityTransferMock->expects($this->exactly(2))->method('getIdKlettiesOrder')->willReturn(1);
        $this->factoryMock->expects($this->never())->method('getQueryContainer')->willReturn($this->klettiesQueryContainerMock);
        $this->klettiesQueryContainerMock->expects($this->never())->method('createApiItem')->willReturn($this->apiItemTransferMock);

        $catch = null;
        try {
            $this->repository->convert($this->orderEntityTransferMock);
        } catch (Exception $exception) {
            $catch = $exception;
        }

        $this->assertNotNull($catch);
        $this->assertInstanceOf(KlettiesOrderNotFoundException::class, $catch);
    }
}
