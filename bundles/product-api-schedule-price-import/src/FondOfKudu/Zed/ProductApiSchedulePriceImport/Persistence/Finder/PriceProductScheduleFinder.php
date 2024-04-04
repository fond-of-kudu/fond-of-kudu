<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\Finder;

use FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\Mapper\PriceProductScheduleMapperInterface;
use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Orm\Zed\PriceProductSchedule\Persistence\SpyPriceProductScheduleQuery;
use Propel\Runtime\ActiveQuery\Criteria;

class PriceProductScheduleFinder implements PriceProductScheduleFinderInterface
{
    /**
     * @var \Orm\Zed\PriceProductSchedule\Persistence\SpyPriceProductScheduleQuery
     */
    protected SpyPriceProductScheduleQuery $priceProductScheduleQuery;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\Mapper\PriceProductScheduleMapperInterface
     */
    protected PriceProductScheduleMapperInterface $priceProductScheduleMapper;

    /**
     * @param \Orm\Zed\PriceProductSchedule\Persistence\SpyPriceProductScheduleQuery $priceProductScheduleQuery
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\Mapper\PriceProductScheduleMapperInterface $priceProductScheduleMapper
     */
    public function __construct(
        SpyPriceProductScheduleQuery $priceProductScheduleQuery,
        PriceProductScheduleMapperInterface $priceProductScheduleMapper
    ) {
        $this->priceProductScheduleQuery = $priceProductScheduleQuery;
        $this->priceProductScheduleMapper = $priceProductScheduleMapper;
    }

    /**
     * @param int $idProductAbstract
     *
     * @return \Generated\Shared\Transfer\PriceProductScheduleTransfer|null
     */
    public function findLatestPriceProductScheduleByIdProductAbstract(
        int $idProductAbstract
    ): ?PriceProductScheduleTransfer {
        $priceProductScheduleEntity = $this->priceProductScheduleQuery
            ->filterByFkProductAbstract($idProductAbstract)
            ->orderByActiveTo(Criteria::DESC)
            ->findOne();

        if ($priceProductScheduleEntity === null) {
            return null;
        }

        return $this->priceProductScheduleMapper
            ->mapPriceProductScheduleEntityToPriceProductScheduleTransfer(
                $priceProductScheduleEntity,
                new PriceProductScheduleTransfer(),
            );
    }
}
