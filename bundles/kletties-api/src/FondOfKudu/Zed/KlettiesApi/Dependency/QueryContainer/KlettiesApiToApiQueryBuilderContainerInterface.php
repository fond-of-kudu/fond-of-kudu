<?php

namespace FondOfKudu\Zed\KlettiesApi\Dependency\QueryContainer;

use Generated\Shared\Transfer\ApiQueryBuilderQueryTransfer;
use Propel\Runtime\ActiveQuery\ModelCriteria;

interface KlettiesApiToApiQueryBuilderContainerInterface
{
    /**
     * @param \Propel\Runtime\ActiveQuery\ModelCriteria $query
     * @param \Generated\Shared\Transfer\ApiQueryBuilderQueryTransfer $apiQueryBuilderQueryTransfer
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    public function buildQueryFromRequest(ModelCriteria $query, ApiQueryBuilderQueryTransfer $apiQueryBuilderQueryTransfer): ModelCriteria;
}
