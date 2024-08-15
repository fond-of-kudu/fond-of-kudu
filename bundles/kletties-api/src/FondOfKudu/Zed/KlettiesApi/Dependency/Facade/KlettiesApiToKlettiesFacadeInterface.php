<?php

namespace FondOfKudu\Zed\KlettiesApi\Dependency\Facade;

use Generated\Shared\Transfer\KlettiesOrderTransfer;

interface KlettiesApiToKlettiesFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\KlettiesOrderTransfer $klettiesOrderTransfer
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer
     */
    public function updateKlettiesOrder(KlettiesOrderTransfer $klettiesOrderTransfer): KlettiesOrderTransfer;

    /**
     * @param int $id
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer|null
     */
    public function findKlettiesOrderById(int $id): ?KlettiesOrderTransfer;
}
