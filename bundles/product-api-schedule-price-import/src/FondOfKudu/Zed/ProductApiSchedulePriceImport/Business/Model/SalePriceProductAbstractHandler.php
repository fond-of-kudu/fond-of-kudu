<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model;

use DateTime;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToCurrencyFacadeInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductFacadeInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToStoreFacadeInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportRepositoryInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig;
use Generated\Shared\Transfer\MoneyValueTransfer;
use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;

class SalePriceProductAbstractHandler implements SalePriceProductAbstractHandlerInterface
{
    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface
     */
    protected ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface $priceProductScheduleFacade;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig
     */
    protected ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportRepositoryInterface
     */
    protected ProductApiSchedulePriceImportRepositoryInterface $productApiSchedulePriceImportRepository;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToCurrencyFacadeInterface
     */
    protected ProductApiSchedulePriceImportToCurrencyFacadeInterface $currencyFacade;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToStoreFacadeInterface
     */
    protected ProductApiSchedulePriceImportToStoreFacadeInterface $storeFacade;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductFacadeInterface
     */
    protected ProductApiSchedulePriceImportToPriceProductFacadeInterface $priceProductFacade;

    /**
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface $priceProductScheduleFacade
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToCurrencyFacadeInterface $currencyFacade
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToStoreFacadeInterface $storeFacade
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductFacadeInterface $priceProductFacade
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportRepositoryInterface $productApiSchedulePriceImportRepository
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig
     */
    public function __construct(
        ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface $priceProductScheduleFacade,
        ProductApiSchedulePriceImportToCurrencyFacadeInterface $currencyFacade,
        ProductApiSchedulePriceImportToStoreFacadeInterface $storeFacade,
        ProductApiSchedulePriceImportToPriceProductFacadeInterface $priceProductFacade,
        ProductApiSchedulePriceImportRepositoryInterface $productApiSchedulePriceImportRepository,
        ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig
    ) {
        $this->priceProductScheduleFacade = $priceProductScheduleFacade;
        $this->apiSchedulePriceImportConfig = $apiSchedulePriceImportConfig;
        $this->productApiSchedulePriceImportRepository = $productApiSchedulePriceImportRepository;
        $this->currencyFacade = $currencyFacade;
        $this->storeFacade = $storeFacade;
        $this->priceProductFacade = $priceProductFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function handle(ProductAbstractTransfer $productAbstractTransfer): ProductAbstractTransfer
    {
        if (!$this->validateSpecialPriceAttributes($productAbstractTransfer)) {
            return $productAbstractTransfer;
        }

        $currencyTransfer = $this->currencyFacade->getCurrent();
        $storeTransfer = $this->storeFacade->getCurrentStore();

        $priceProductScheduleTransfer = $this->productApiSchedulePriceImportRepository
            ->findPriceProductScheduleByIdProductAbstractAndIdCurrencyAndIdStore(
                $productAbstractTransfer->getIdProductAbstract(),
                $currencyTransfer->getIdCurrency(),
                $storeTransfer->getIdStore(),
            );

        if ($priceProductScheduleTransfer !== null && $this->hasDataChanged($priceProductScheduleTransfer, $productAbstractTransfer->getAttributes())) {
            $this->priceProductScheduleFacade->removeAndApplyPriceProductSchedule(
                $priceProductScheduleTransfer->getIdPriceProductSchedule(),
            );
        }

        $grossAmount = $productAbstractTransfer->getAttributes()[$this->apiSchedulePriceImportConfig->getProductAttributeSalePrice()];
        $activeFrom = $productAbstractTransfer->getAttributes()[$this->apiSchedulePriceImportConfig->getProductAttributeSalePriceFrom()];
        $activeTo = $productAbstractTransfer->getAttributes()[$this->apiSchedulePriceImportConfig->getProductAttributeSalePriceTo()];

        $priceTypeTransfer = $this->priceProductFacade->findPriceTypeByName(
            $this->apiSchedulePriceImportConfig->getPriceDimensionRrp(),
        );

        $moneyValueTransfer = (new MoneyValueTransfer())
            ->setFkStore($storeTransfer->getIdStore())
            ->setFkCurrency($currencyTransfer->getIdCurrency())
            ->setCurrency($currencyTransfer)
            ->setGrossAmount($grossAmount)
            ->setStore($storeTransfer);

        $priceProductTransfer = (new PriceProductTransfer())
            ->setMoneyValue($moneyValueTransfer)
            ->setIdProductAbstract($productAbstractTransfer->getIdProductAbstract())
            ->setPriceType($priceTypeTransfer);

        $priceProductScheduleTransfer = (new PriceProductScheduleTransfer())
            ->setPriceProduct($priceProductTransfer)
            ->setActiveFrom($activeFrom)
            ->setActiveTo($activeTo);

        $this->priceProductScheduleFacade->createAndApplyPriceProductSchedule($priceProductScheduleTransfer);

        return $productAbstractTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductScheduleTransfer $priceProductScheduleTransfer
     * @param array $productAttributes
     *
     * @return bool
     */
    protected function hasDataChanged(
        PriceProductScheduleTransfer $priceProductScheduleTransfer,
        array $productAttributes
    ): bool {
        $specialPriceFrom = $productAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePriceFrom()];
        $specialPriceTo = $productAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePriceTo()];
        $specialPrice = $productAttributes[$this->apiSchedulePriceImportConfig->getProductAttributeSalePrice()];

        $specialPriceFrom = new DateTime($specialPriceFrom);
        $specialPriceTo = new DateTime($specialPriceTo);

        $priceProductScheduleActiveFrom = new DateTime($priceProductScheduleTransfer->getActiveFrom());
        $priceProductScheduleActiveTo = new DateTime($priceProductScheduleTransfer->getActiveTo());
        $priceProductScheduleGrossAmount = $priceProductScheduleTransfer->getPriceProduct()->getMoneyValue()->getGrossAmount();

        if ($specialPriceFrom->format('Y-m-d') !== $priceProductScheduleActiveFrom->format('Y-m-d')) {
            return true;
        }

        if ($specialPriceTo->format('Y-m-d') !== $priceProductScheduleActiveTo->format('Y-m-d')) {
            return true;
        }

        if ((int)$specialPrice !== $priceProductScheduleGrossAmount) {
            return true;
        }

        return false;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return bool
     */
    protected function validateSpecialPriceAttributes(ProductAbstractTransfer $productAbstractTransfer): bool
    {
        $required = [
            $this->apiSchedulePriceImportConfig->getProductAttributeSalePrice(),
            $this->apiSchedulePriceImportConfig->getProductAttributeSalePriceFrom(),
            $this->apiSchedulePriceImportConfig->getProductAttributeSalePriceTo(),
        ];

        foreach ($required as $attribute) {
            if (!isset($productAbstractTransfer->getAttributes()[$attribute])) {
                return false;
            }

            if (!$productAbstractTransfer->getAttributes()[$attribute]) {
                return false;
            }
        }

        return true;
    }
}
