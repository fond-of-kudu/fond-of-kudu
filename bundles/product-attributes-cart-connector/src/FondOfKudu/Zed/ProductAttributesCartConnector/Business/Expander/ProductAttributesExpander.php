<?php

namespace FondOfKudu\Zed\ProductAttributesCartConnector\Business\Expander;

use FondOfKudu\Zed\ProductAttributesCartConnector\Persistence\ProductAttributesCartConnectorRepository;
use Generated\Shared\Transfer\CartChangeTransfer;

class ProductAttributesExpander implements ProductAttributesExpanderInterface
{
    /**
     * @var \FondOfKudu\Zed\ProductAttributesCartConnector\Persistence\ProductAttributesCartConnectorRepository
     */
    protected ProductAttributesCartConnectorRepository $repository;

    /**
     * @param \FondOfKudu\Zed\ProductAttributesCartConnector\Persistence\ProductAttributesCartConnectorRepository $repository
     */
    public function __construct(
        ProductAttributesCartConnectorRepository $repository
    ) {
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\CartChangeTransfer $cartChangeTransfer
     *
     * @return \Generated\Shared\Transfer\CartChangeTransfer
     */
    public function expandItems(CartChangeTransfer $cartChangeTransfer): CartChangeTransfer
    {
        $items = [];
        foreach ($cartChangeTransfer->getItems() as $item) {
            $items[$item->getIdProductAbstract()] = $item;
        }

        $this->expandItemsWithAbstractAttributes($items);

        return $cartChangeTransfer;
    }

    /**
     * @param array<\Generated\Shared\Transfer\ItemTransfer> $items
     *
     * @return void
     */
    protected function expandItemsWithAbstractAttributes(array $items): void
    {
        $abstractAttributes = $this->repository->getProductAbstractAttributes(array_keys($items));

        foreach ($items as $itemTransfer) {
            $itemTransfer->setAbstractAttributes(['_' => $abstractAttributes[$itemTransfer->getIdProductAbstract()]]);
        }
    }
}
