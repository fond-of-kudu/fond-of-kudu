<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model;

use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapperInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportRepositoryInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig;
use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Psr\Log\LoggerInterface;
use Spryker\Shared\Kernel\Transfer\Exception\NullValueException;

class SalePriceProductConcreteHandler implements SalePriceProductConcreteHandlerInterface
{
    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig
     */
    protected ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportRepositoryInterface
     */
    protected ProductApiSchedulePriceImportRepositoryInterface $productApiSchedulePriceImportRepository;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapperInterface
     */
    protected PriceProductScheduleMapperInterface $priceProductScheduleMapper;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface
     */
    protected ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface $priceProductScheduleFacade;

    private LoggerInterface $logger;

    /**
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface $priceProductScheduleFacade
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Mapper\PriceProductScheduleMapperInterface $priceProductScheduleMapper
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportRepositoryInterface $productApiSchedulePriceImportRepository
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface $priceProductScheduleFacade,
        PriceProductScheduleMapperInterface $priceProductScheduleMapper,
        ProductApiSchedulePriceImportRepositoryInterface $productApiSchedulePriceImportRepository,
        ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig,
        LoggerInterface $logger
    ) {
        $this->apiSchedulePriceImportConfig = $apiSchedulePriceImportConfig;
        $this->productApiSchedulePriceImportRepository = $productApiSchedulePriceImportRepository;
        $this->priceProductScheduleMapper = $priceProductScheduleMapper;
        $this->priceProductScheduleFacade = $priceProductScheduleFacade;
        $this->logger = $logger;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     * @param array $attributes
     *
     * @return void
     */
    public function handle(
        ProductConcreteTransfer $productConcreteTransfer,
        array $attributes = []
    ): void {
        foreach ($productConcreteTransfer->getPrices() as $priceProductTransfer) {
            try {
                $priceProductScheduleTransfer = $this->productApiSchedulePriceImportRepository
                    ->findPriceProductScheduleByIdProductAbstractAndIdCurrencyAndIdStore(
                        $productConcreteTransfer->getIdProductConcreteOrFail(),
                        $priceProductTransfer->getMoneyValue()->getFkCurrencyOrFail(),
                        $priceProductTransfer->getMoneyValue()->getFkStoreOrFail(),
                    );
            } catch (NullValueException $exception) {
                $this->logger->critical($exception->getMessage());

                continue;
            }

            if ($priceProductScheduleTransfer === null) {
                $this->create($priceProductTransfer, $attributes);
            } else {
                $this->update($priceProductScheduleTransfer, $attributes);
            }
        }
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     * @param array $attributes
     *
     * @return void
     */
    protected function create(PriceProductTransfer $priceProductTransfer, array $attributes): void
    {
        $priceProductScheduleTransfer = $this->priceProductScheduleMapper->createFromProductConcreteTransfer(
            $priceProductTransfer,
            $attributes,
        );

        $this->priceProductScheduleFacade->createAndApplyPriceProductSchedule($priceProductScheduleTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductScheduleTransfer $priceProductScheduleTransfer
     * @param array $attributes
     *
     * @return void
     */
    protected function update(
        PriceProductScheduleTransfer $priceProductScheduleTransfer,
        array $attributes
    ): void {
        $specialPriceFrom = $attributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePriceFrom()];
        $specialPriceTo = $attributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePriceTo()];
        $specialPrice = $attributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePrice()];

        $priceProductScheduleTransfer
            ->setActiveFrom($specialPriceFrom)
            ->setActiveTo($specialPriceTo)
            ->getPriceProduct()->getMoneyValue()->setGrossAmount($specialPrice);

        $this->priceProductScheduleFacade->updateAndApplyPriceProductSchedule($priceProductScheduleTransfer);
    }
}
