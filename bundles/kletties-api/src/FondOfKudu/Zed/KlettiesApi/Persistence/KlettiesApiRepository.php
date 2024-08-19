<?php

namespace FondOfKudu\Zed\KlettiesApi\Persistence;

use FondOfKudu\Zed\Kletties\Exception\KlettiesOrderNotFoundException;
use FondOfKudu\Zed\KlettiesApi\Dependency\QueryContainer\KlettiesApiToApiQueryBuilderContainerInterface;
use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiPaginationTransfer;
use Generated\Shared\Transfer\ApiQueryBuilderQueryTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;
use Generated\Shared\Transfer\FokKlettiesOrderEntityTransfer;
use Generated\Shared\Transfer\PropelQueryBuilderColumnSelectionTransfer;
use Generated\Shared\Transfer\PropelQueryBuilderColumnTransfer;
use Orm\Zed\Kletties\Persistence\FokKlettiesOrderQuery;
use Orm\Zed\Kletties\Persistence\Map\FokKlettiesOrderTableMap;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Map\TableMap;
use Spryker\Zed\Api\ApiConfig;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method \FondOfKudu\Zed\KlettiesApi\Persistence\KlettiesApiPersistenceFactory getFactory()
 */
class KlettiesApiRepository extends AbstractRepository implements KlettiesApiRepositoryInterface
{
    /**
     * @var \Orm\Zed\Kletties\Persistence\FokKlettiesOrderQuery
     */
    protected $orderQuery;

    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Dependency\QueryContainer\KlettiesApiToApiQueryBuilderContainerInterface
     */
    protected $queryBuilderContainer;

    /**
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ApiCollectionTransfer
     */
    public function find(ApiRequestTransfer $apiRequestTransfer): ApiCollectionTransfer
    {
        $query = $this->buildQuery($apiRequestTransfer);

        $collection = $this->getFactory()->createTransferMapper()->toTransferCollection(
            $query->find()->getData(),
        );

        foreach ($collection as $id => $orderTransfer) {
            $collection[$id] = $this->convert($orderTransfer)->getData();
        }

        $apiCollectionTransfer = $this->getFactory()
            ->getApiFacade()
            ->createApiCollection([])
            ->setData($collection);

        return $this->addPagination($query, $apiCollectionTransfer, $apiRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\FokKlettiesOrderEntityTransfer $orderEntityTransfer
     *
     * @throws \FondOfKudu\Zed\Kletties\Exception\KlettiesOrderNotFoundException
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function convert(FokKlettiesOrderEntityTransfer $orderEntityTransfer): ApiItemTransfer
    {
        $orderTransfer = $this->getFactory()->getKlettiesFacade()->findKlettiesOrderById($orderEntityTransfer->getIdKlettiesOrder());

        if ($orderTransfer === null) {
            throw new KlettiesOrderNotFoundException(sprintf('Order with ID %s not found!', $orderEntityTransfer->getIdKlettiesOrder()));
        }

        return $this->getFactory()->getApiFacade()->createApiItem($orderTransfer, (string)$orderTransfer->getId());
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\ModelCriteria $query
     * @param \Generated\Shared\Transfer\ApiCollectionTransfer $apiCollectionTransfer
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return \Generated\Shared\Transfer\ApiCollectionTransfer|array
     */
    protected function addPagination(ModelCriteria $query, ApiCollectionTransfer $apiCollectionTransfer, ApiRequestTransfer $apiRequestTransfer)
    {
        $query->setOffset(0);
        $query->setLimit(-1);
        $total = $query->count();
        $page = $apiRequestTransfer->getFilter()->getLimit() ? ($apiRequestTransfer->getFilter()->getOffset() / $apiRequestTransfer->getFilter()->getLimit() + 1) : 1;
        $pageTotal = ($total && $apiRequestTransfer->getFilter()->getLimit()) ? (int)ceil($total / $apiRequestTransfer->getFilter()->getLimit()) : 1;
        if ($page > $pageTotal) {
            throw new NotFoundHttpException('Out of bounds.', null, ApiConfig::HTTP_CODE_NOT_FOUND);
        }

        $apiPaginationTransfer = new ApiPaginationTransfer();
        $apiPaginationTransfer->setItemsPerPage($apiRequestTransfer->getFilter()->getLimit());
        $apiPaginationTransfer->setPage($page);
        $apiPaginationTransfer->setTotal($total);
        $apiPaginationTransfer->setPageTotal($pageTotal);

        $apiCollectionTransfer->setPagination($apiPaginationTransfer);

        return $apiCollectionTransfer;
    }

    /**
     * @return \Orm\Zed\Kletties\Persistence\FokKlettiesOrderQuery
     */
    protected function getOrderQuery(): FokKlettiesOrderQuery
    {
        if ($this->orderQuery === null) {
            $this->orderQuery = $this->getFactory()->getKlettiesOrderQuery();
        }

        return $this->orderQuery;
    }

    /**
     * @return \FondOfKudu\Zed\KlettiesApi\Dependency\QueryContainer\KlettiesApiToApiQueryBuilderContainerInterface
     */
    protected function getQueryBuilderContainer(): KlettiesApiToApiQueryBuilderContainerInterface
    {
        if ($this->queryBuilderContainer === null) {
            $this->queryBuilderContainer = $this->getFactory()->getQueryBuilderContainer();
        }

        return $this->queryBuilderContainer;
    }

    /**
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    protected function buildQuery(ApiRequestTransfer $apiRequestTransfer)
    {
        $apiQueryBuilderQueryTransfer = $this->buildApiQueryBuilderQuery($apiRequestTransfer);

        $query = $this->getOrderQuery();
        $query = $this->getQueryBuilderContainer()->buildQueryFromRequest($query, $apiQueryBuilderQueryTransfer);

        return $query;
    }

    /**
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ApiQueryBuilderQueryTransfer
     */
    protected function buildApiQueryBuilderQuery(ApiRequestTransfer $apiRequestTransfer)
    {
        $columnSelectionTransfer = $this->buildColumnSelection();

        $apiQueryBuilderQueryTransfer = new ApiQueryBuilderQueryTransfer();
        $apiQueryBuilderQueryTransfer->setApiRequest($apiRequestTransfer);
        $apiQueryBuilderQueryTransfer->setColumnSelection($columnSelectionTransfer);

        return $apiQueryBuilderQueryTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\PropelQueryBuilderColumnSelectionTransfer
     */
    protected function buildColumnSelection(): PropelQueryBuilderColumnSelectionTransfer
    {
        $columnSelectionTransfer = new PropelQueryBuilderColumnSelectionTransfer();
        $tableColumns = FokKlettiesOrderTableMap::getFieldNames(TableMap::TYPE_FIELDNAME);

        foreach ($tableColumns as $columnAlias) {
            $columnTransfer = new PropelQueryBuilderColumnTransfer();
            $columnTransfer->setName(FokKlettiesOrderTableMap::TABLE_NAME . '.' . $columnAlias);
            $columnTransfer->setAlias($columnAlias);

            $columnSelectionTransfer->addTableColumn($columnTransfer);
        }

        return $columnSelectionTransfer;
    }
}
