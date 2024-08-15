<?php

namespace FondOfKudu\Zed\KlettiesApi\Communication\Plugin\Api;

use FondOfKudu\Shared\KlettiesApi\KlettiesApiConstants;
use Generated\Shared\Transfer\ApiRequestTransfer;
use Spryker\Zed\ApiExtension\Dependency\Plugin\ApiValidatorPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfKudu\Zed\KlettiesApi\Business\KlettiesApiFacadeInterface getFacade()
 * @method \FondOfKudu\Zed\KlettiesApi\Business\KlettiesApiBusinessFactory getFactory()
 */
class KlettiesApiValidatorPlugin extends AbstractPlugin implements ApiValidatorPluginInterface
{
    /**
     * @return string
     */
    public function getResourceName(): string
    {
        return KlettiesApiConstants::RESOURCE_KLETTIES_ORDERS_API;
    }

    /**
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return array<\Generated\Shared\Transfer\ApiValidationErrorTransfer>
     */
    public function validate(ApiRequestTransfer $apiRequestTransfer): array
    {
        return $this->getFacade()->validate($apiRequestTransfer);
    }
}
