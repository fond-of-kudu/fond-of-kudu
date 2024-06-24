<?php

namespace FondOfKudu\Zed\CustomerPasswordChangedAtConnector\Business\CustomerExpander;

use Codeception\Test\Unit;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\CustomerExpander\CustomerExpander;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\CustomerExpander\CustomerExpanderInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Customer\Dependency\Plugin\CustomerTransferExpanderPluginInterface;

class CustomerExpanderTest extends Unit
{
    /**
     * @var array<\PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Customer\Dependency\Plugin\CustomerTransferExpanderPluginInterface>
     */
    protected array $plugins;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Customer\Dependency\Plugin\CustomerTransferExpanderPluginInterface
     */
    protected MockObject|CustomerTransferExpanderPluginInterface $customerTransferExpanderPluginMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected MockObject|CustomerTransfer $customerTransferMock;

    /**
     * @var \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\CustomerExpander\CustomerExpanderInterface
     */
    protected CustomerExpanderInterface $expander;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->customerTransferExpanderPluginMock = $this->createMock(CustomerTransferExpanderPluginInterface::class);
        $this->plugins = [$this->customerTransferExpanderPluginMock];
        $this->customerTransferMock = $this->createMock(CustomerTransfer::class);
        $this->expander = new CustomerExpander($this->plugins);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->customerTransferExpanderPluginMock->expects(static::atLeastOnce())
            ->method('expandTransfer')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerTransferMock);

        static::assertEquals(
            $this->expander->expand($this->customerTransferMock),
            $this->customerTransferMock,
        );
    }
}
