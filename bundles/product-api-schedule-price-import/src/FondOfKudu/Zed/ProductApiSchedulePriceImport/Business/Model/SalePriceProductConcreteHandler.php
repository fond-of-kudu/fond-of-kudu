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

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected LoggerInterface $logger;

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
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function handle(ProductConcreteTransfer $productConcreteTransfer): ProductConcreteTransfer
    {
        if (!$this->validateSpecialPriceAttributes($productConcreteTransfer->getAttributes())) {
            return $productConcreteTransfer;
        }

        foreach ($productConcreteTransfer->getPrices() as $priceProductTransfer) {
            $priceProductScheduleTransfer = $this->productApiSchedulePriceImportRepository
                ->findPriceProductScheduleByIdProductConcreteAndIdCurrencyAndIdStore(
                    $productConcreteTransfer->getIdProductConcrete(),
                    $priceProductTransfer->getMoneyValue()->getFkCurrency(),
                    $priceProductTransfer->getMoneyValue()->getFkStore(),
                );

            if ($priceProductScheduleTransfer !== null) {
                $this->priceProductScheduleFacade->removeAndApplyPriceProductSchedule(
                    $priceProductScheduleTransfer->getIdPriceProductSchedule(),
                );
            }

            $this->create($priceProductTransfer, $productConcreteTransfer);
        }

        return $productConcreteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @return void
     */
    protected function create(
        PriceProductTransfer $priceProductTransfer,
        ProductConcreteTransfer $productConcreteTransfer
    ): void {
        $priceProductScheduleTransfer = $this->priceProductScheduleMapper->createFromProductConcreteTransfer(
            $priceProductTransfer,
            $productConcreteTransfer,
        );

        $this->priceProductScheduleFacade->createAndApplyPriceProductSchedule($priceProductScheduleTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductScheduleTransfer $priceProductScheduleTransfer
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @return void
     */
    protected function update(
        PriceProductScheduleTransfer $priceProductScheduleTransfer,
        ProductConcreteTransfer $productConcreteTransfer
    ): void {
        $productConcreteAttributes = $productConcreteTransfer->getAttributes();
        $specialPriceFrom = $productConcreteAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePriceFrom()];
        $specialPriceTo = $productConcreteAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePriceTo()];
        $specialPrice = $productConcreteAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePrice()];

        $priceProductScheduleTransfer
            ->setActiveFrom($specialPriceFrom)
            ->setActiveTo($specialPriceTo)
            ->getPriceProduct()->getMoneyValue()->setGrossAmount($specialPrice);

        $this->priceProductScheduleFacade->removeAndApplyPriceProductSchedule(
            $priceProductScheduleTransfer->getIdPriceProductSchedule(),
        );

        $this->priceProductScheduleFacade->updateAndApplyPriceProductSchedule($priceProductScheduleTransfer);
    }

    /**
     * @param array $productAttributes
     *
     * @return bool
     */
    protected function validateSpecialPriceAttributes(array $productAttributes): bool
    {
        $required = [
            $this->apiSchedulePriceImportConfig->getProductAttributeSalePrice(),
            $this->apiSchedulePriceImportConfig->getProductAttributeSalePriceFrom(),
            $this->apiSchedulePriceImportConfig->getProductAttributeSalePriceTo(),
        ];

        foreach ($required as $item) {
            if (!isset($productAttributes[$item])) {
                return false;
            }

            if (!$productAttributes[$item]) {
                return false;
            }
        }

        return true;
    }
}
