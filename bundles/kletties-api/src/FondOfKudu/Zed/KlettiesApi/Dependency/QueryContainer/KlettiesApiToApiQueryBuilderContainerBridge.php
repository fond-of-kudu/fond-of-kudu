<?php

namespace FondOfKudu\Zed\KlettiesApi\Dependency\QueryContainer;

use Generated\Shared\Transfer\ApiQueryBuilderQueryTransfer;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Spryker\Zed\ApiQueryBuilder\Persistence\ApiQueryBuilderQueryContainerInterface;

class KlettiesApiToApiQueryBuilderContainerBridge implements KlettiesApiToApiQueryBuilderContainerInterface
{
    /**
     * @var \Spryker\Zed\ApiQueryBuilder\Persistence\ApiQueryBuilderQueryContainerInterface
     */
    protected ApiQueryBuilderQueryContainerInterface $apiQueryBuilderQueryContainer;

    /**
     * @param \Spryker\Zed\ApiQueryBuilder\Persistence\ApiQueryBuilderQueryContainerInterface $apiQueryBuilderQueryContainer
     */
    public function __construct(ApiQueryBuilderQueryContainerInterface $apiQueryBuilderQueryContainer)
    {
        $this->apiQueryBuilderQueryContainer = $apiQueryBuilderQueryContainer;
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\ModelCriteria $query
     * @param \Generated\Shared\Transfer\ApiQueryBuilderQueryTransfer $apiQueryBuilderQueryTransfer
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    public function buildQueryFromRequest(ModelCriteria $query, ApiQueryBuilderQueryTransfer $apiQueryBuilderQueryTransfer): ModelCriteria
    {
        return $this->apiQueryBuilderQueryContainer->buildQueryFromRequest($query, $apiQueryBuilderQueryTransfer);
    }
}
