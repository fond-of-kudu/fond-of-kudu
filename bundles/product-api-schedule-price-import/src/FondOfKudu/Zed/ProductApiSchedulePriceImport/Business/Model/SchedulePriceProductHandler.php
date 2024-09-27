<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model;

use FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Validator\SpecialPriceAttributesValidatorInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface;
use FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig;
use Generated\Shared\Transfer\PriceProductScheduleTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;

class SchedulePriceProductHandler implements SchedulePriceProductHandlerInterface
{
    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig
     */
    protected ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Validator\SpecialPriceAttributesValidatorInterface
     */
    protected SpecialPriceAttributesValidatorInterface $specialPriceAttributesValidator;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SchedulePriceProductAbstractModelInterface
     */
    protected SchedulePriceProductAbstractModelInterface $schedulePriceProductAbstractModel;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SchedulePriceProductConcreteModelInterface
     */
    protected SchedulePriceProductConcreteModelInterface $schedulePriceProductConcreteModel;

    /**
     * @var \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface
     */
    protected ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface $priceProductScheduleFacade;

    /**
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Dependency\Facade\ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface $priceProductScheduleFacade
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SchedulePriceProductAbstractModelInterface $schedulePriceProductAbstractModel
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model\SchedulePriceProductConcreteModelInterface $schedulePriceProductConcreteModel
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Validator\SpecialPriceAttributesValidatorInterface $specialPriceAttributesValidator
     * @param \FondOfKudu\Zed\ProductApiSchedulePriceImport\ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig
     */
    public function __construct(
        ProductApiSchedulePriceImportToPriceProductScheduleFacadeInterface $priceProductScheduleFacade,
        SchedulePriceProductAbstractModelInterface $schedulePriceProductAbstractModel,
        SchedulePriceProductConcreteModelInterface $schedulePriceProductConcreteModel,
        SpecialPriceAttributesValidatorInterface $specialPriceAttributesValidator,
        ProductApiSchedulePriceImportConfig $apiSchedulePriceImportConfig
    ) {
        $this->priceProductScheduleFacade = $priceProductScheduleFacade;
        $this->apiSchedulePriceImportConfig = $apiSchedulePriceImportConfig;
        $this->specialPriceAttributesValidator = $specialPriceAttributesValidator;
        $this->schedulePriceProductAbstractModel = $schedulePriceProductAbstractModel;
        $this->schedulePriceProductConcreteModel = $schedulePriceProductConcreteModel;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function handleProductAbstract(ProductAbstractTransfer $productAbstractTransfer): ProductAbstractTransfer
    {
        $productAttributes = $productAbstractTransfer->getAttributes();
        $hasRequiredProductAttributes = $this->specialPriceAttributesValidator->hasRequiredProductAttributes($productAttributes);
        $areProductAttributesValid = $this->specialPriceAttributesValidator->validateProductAttributeValues($productAttributes);
        $priceProductScheduleTransfer = $this->schedulePriceProductAbstractModel
            ->getPriceProductScheduleTransfer($productAbstractTransfer->getIdProductAbstract());

        if ($priceProductScheduleTransfer === null && $hasRequiredProductAttributes && $areProductAttributesValid) {
            $this->schedulePriceProductAbstractModel->create($productAbstractTransfer);

            return $productAbstractTransfer;
        }

        $hasDataChanged = $this->hasDataChanged($priceProductScheduleTransfer, $productAttributes);

        if ($hasRequiredProductAttributes && $areProductAttributesValid && $hasDataChanged) {
            $this->schedulePriceProductAbstractModel->update($productAbstractTransfer);

            return $productAbstractTransfer;
        }

        return $productAbstractTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function handleProductConcrete(ProductConcreteTransfer $productConcreteTransfer): ProductConcreteTransfer
    {
        $productAttributes = $productConcreteTransfer->getAttributes();
        $hasRequiredProductAttributes = $this->specialPriceAttributesValidator->hasRequiredProductAttributes($productAttributes);
        $areProductAttributesValid = $this->specialPriceAttributesValidator->validateProductAttributeValues($productAttributes);
        $priceProductScheduleTransfer = $this->schedulePriceProductConcreteModel
            ->getPriceProductScheduleTransfer($productConcreteTransfer->getIdProductConcrete());

        if ($priceProductScheduleTransfer === null && $hasRequiredProductAttributes && $areProductAttributesValid) {
            $this->schedulePriceProductConcreteModel->create($productConcreteTransfer);

            return $productConcreteTransfer;
        }

        $hasDataChanged = $this->hasDataChanged($priceProductScheduleTransfer, $productAttributes);

        if ($hasRequiredProductAttributes && $areProductAttributesValid && $hasDataChanged) {
            $this->schedulePriceProductConcreteModel->update($productConcreteTransfer, $priceProductScheduleTransfer);

            return $productConcreteTransfer;
        }

        return $productConcreteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductScheduleTransfer|null $priceProductScheduleTransfer
     * @param array $productAttributes
     *
     * @return bool
     */
    protected function hasDataChanged(?PriceProductScheduleTransfer $priceProductScheduleTransfer, array $productAttributes): bool
    {
        if ($this->specialPriceAttributesValidator->hasSpecialPriceChanged($priceProductScheduleTransfer, $productAttributes)) {
            // Whenever the data has changed, the existing price must be deleted.
            $this->priceProductScheduleFacade->removeAndApplyPriceProductSchedule(
                $priceProductScheduleTransfer->getIdPriceProductSchedule(),
            );

            return true;
        }

        return false;
    }
}
