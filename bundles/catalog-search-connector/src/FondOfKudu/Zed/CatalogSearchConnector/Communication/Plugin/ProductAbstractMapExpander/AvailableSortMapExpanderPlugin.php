<?php

namespace FondOfKudu\Zed\CatalogSearchConnector\Communication\Plugin\ProductAbstractMapExpander;

use FondOfKudu\Shared\CatalogSearchConnector\CatalogSearchConnectorConstants;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\PageMapTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductPageSearchExtension\Dependency\PageMapBuilderInterface;
use Spryker\Zed\ProductPageSearchExtension\Dependency\Plugin\ProductAbstractMapExpanderPluginInterface;

/**
 * @method \FondOfKudu\Zed\CatalogSearchConnector\Communication\CatalogSearchConnectorCommunicationFactory getFactory()
 */
class AvailableSortMapExpanderPlugin extends AbstractPlugin implements ProductAbstractMapExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\PageMapTransfer $pageMapTransfer
     * @param \Spryker\Zed\ProductPageSearchExtension\Dependency\PageMapBuilderInterface $pageMapBuilder
     * @param array $productData
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return \Generated\Shared\Transfer\PageMapTransfer
     */
    public function expandProductMap(
        PageMapTransfer $pageMapTransfer,
        PageMapBuilderInterface $pageMapBuilder,
        array $productData,
        LocaleTransfer $localeTransfer
    ): PageMapTransfer {
        $available = (int)$productData[CatalogSearchConnectorConstants::ATTR_AVAILABLE];

        $pageMapBuilder->addIntegerSort($pageMapTransfer, CatalogSearchConnectorConstants::ATTR_AVAILABLE, $available);
        $pageMapBuilder->addIntegerFacet($pageMapTransfer, CatalogSearchConnectorConstants::ATTR_AVAILABLE, $available);

        return $pageMapTransfer;
    }
}
