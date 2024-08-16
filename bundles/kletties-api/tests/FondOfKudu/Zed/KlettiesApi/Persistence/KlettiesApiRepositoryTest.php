<?php

namespace FondOfKudu\Zed\KlettiesApi\Persistence;

use Codeception\Test\Unit;
use Exception;
use FondOfKudu\Zed\Kletties\Exception\KlettiesOrderNotFoundException;
use FondOfKudu\Zed\Kletties\Persistence\KlettiesPersistenceFactory;
use FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToApiFacadeBridge;
use FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToApiFacadeInterface;
use FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToKlettiesFacadeBridge;
use FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToKlettiesFacadeInterface;
use FondOfKudu\Zed\KlettiesApi\Dependency\QueryContainer\KlettiesApiToApiQueryBuilderContainerBridge;
use FondOfKudu\Zed\KlettiesApi\Dependency\QueryContainer\KlettiesApiToApiQueryBuilderContainerInterface;
use FondOfKudu\Zed\KlettiesApi\Persistence\Propel\Mapper\TransferMapper;
use FondOfKudu\Zed\KlettiesApi\Persistence\Propel\Mapper\TransferMapperInterface;
use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiFilterTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;
use Generated\Shared\Transfer\FokKlettiesOrderEntityTransfer;
use Generated\Shared\Transfer\KlettiesOrderTransfer;
use Orm\Zed\Kletties\Persistence\FokKlettiesOrderQuery;
use PHPUnit\Framework\MockObject\MockObject;
use Propel\Runtime\Collection\ObjectCollection;
use Spryker\Zed\Kernel\Container;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class KlettiesApiRepositoryTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Persistence\KlettiesApiRepositoryInterface
     */
    protected KlettiesApiRepositoryInterface $repository;

    /**
     * @var \Spryker\Zed\Kernel\Container|\PHPUnit\Framework\MockObject\MockObject
     */
    protected Container|MockObject $containerMock;

    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Persistence\KlettiesApiPersistenceFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected KlettiesApiPersistenceFactory|MockObject $factoryMock;

    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Dependency\QueryContainer\KlettiesApiToApiQueryBuilderContainerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected KlettiesApiToApiQueryBuilderContainerInterface|MockObject $klettiesQueryBuilderContainerMock;

    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToApiFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected KlettiesApiToApiFacadeInterface|MockObject $klettiesQueryContainerMock;

    /**
     * @var \Orm\Zed\Kletties\Persistence\FokKlettiesOrderQuery|\PHPUnit\Framework\MockObject\MockObject
     */
    protected FokKlettiesOrderQuery|MockObject $orderQueryMock;

    /**
     * @var \Generated\Shared\Transfer\ApiItemTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ApiItemTransfer|MockObject $apiItemTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ApiCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ApiCollectionTransfer|MockObject $apiCollectionTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ApiDataTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ApiDataTransfer|MockObject $apiDataTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ApiRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ApiRequestTransfer|MockObject $apiRequestTransferMock;

    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Persistence\Propel\Mapper\TransferMapperInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected TransferMapperInterface|MockObject $transferMapperMock;

    /**
     * @var \Propel\Runtime\Collection\ObjectCollection|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ObjectCollection|MockObject $objectCollectionMock;

    /**
     * @var \Generated\Shared\Transfer\ApiFilterTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ApiFilterTransfer|MockObject $apiFilterTransferMock;

    /**
     * @var \Generated\Shared\Transfer\FokKlettiesOrderEntityTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected FokKlettiesOrderEntityTransfer|MockObject $orderEntityTransferMock;

    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToKlettiesFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected KlettiesApiToKlettiesFacadeInterface|MockObject $facadeMock;

    /**
     * @var \Generated\Shared\Transfer\KlettiesOrderTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected KlettiesOrderTransfer|MockObject $orderTransferMock;

    /**
     * @return void
     */
    public function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->createMock(Container::class);
        $this->factoryMock = $this->createMock(KlettiesApiPersistenceFactory::class);
        $this->objectCollectionMock = $this->createMock(ObjectCollection::class);
        $this->klettiesQueryBuilderContainerMock = $this->createMock(KlettiesApiToApiQueryBuilderContainerBridge::class);
        $this->klettiesQueryContainerMock = $this->createMock(KlettiesApiToApiFacadeBridge::class);
        $this->orderQueryMock = $this->createMock(FokKlettiesOrderQuery::class);
        $this->apiItemTransferMock = $this->createMock(ApiItemTransfer::class);
        $this->apiCollectionTransferMock = $this->createMock(ApiCollectionTransfer::class);
        $this->apiDataTransferMock = $this->createMock(ApiDataTransfer::class);
        $this->apiRequestTransferMock = $this->createMock(ApiRequestTransfer::class);
        $this->transferMapperMock = $this->createMock(TransferMapper::class);
        $this->apiFilterTransferMock = $this->createMock(ApiFilterTransfer::class);
        $this->orderEntityTransferMock = $this->createMock(FokKlettiesOrderEntityTransfer::class);
        $this->facadeMock = $this->createMock(KlettiesApiToKlettiesFacadeBridge::class);
        $this->orderTransferMock = $this->createMock(KlettiesOrderTransfer::class);

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
