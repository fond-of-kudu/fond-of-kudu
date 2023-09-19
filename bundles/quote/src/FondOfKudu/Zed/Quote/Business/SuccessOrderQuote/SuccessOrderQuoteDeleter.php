<?php

namespace FondOfKudu\Zed\Quote\Business\SuccessOrderQuote;

use DateInterval;
use DateTime;
use FondOfKudu\Zed\Quote\Persistence\QuoteRepositoryInterface;
use FondOfKudu\Zed\Quote\QuoteConfig;
use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;
use Spryker\Zed\Quote\Persistence\QuoteEntityManagerInterface;

class SuccessOrderQuoteDeleter implements SuccessOrderQuoteDeleterInterface
{
    use TransactionTrait;

    /**
     * @var int
     */
    protected const BATCH_SIZE_LIMIT = 200;

    /**
     * @var \Spryker\Zed\Quote\Persistence\QuoteEntityManagerInterface
     */
    protected QuoteEntityManagerInterface $quoteEntityManager;

    /**
     * @var \FondOfKudu\Zed\Quote\Persistence\QuoteRepositoryInterface
     */
    protected QuoteRepositoryInterface $quoteRepository;

    /**
     * @var \Spryker\Zed\QuoteExtension\Dependency\Plugin\QuoteWritePluginInterface[]
     */
    protected array $quoteDeleteBeforePlugins;

    /**
     * @var \FondOfKudu\Zed\Quote\QuoteConfig
     */
    protected QuoteConfig $config;

    /**
     * @param \Spryker\Zed\Quote\Persistence\QuoteEntityManagerInterface $quoteEntityManager
     * @param \FondOfKudu\Zed\Quote\Persistence\QuoteRepositoryInterface $quoteRepository
     * @param \FondOfKudu\Zed\Quote\QuoteConfig $config
     * @param array<\Spryker\Zed\QuoteExtension\Dependency\Plugin\QuoteWritePluginInterface> $quoteDeleteBeforePlugins
     */
    public function __construct(
        QuoteEntityManagerInterface $quoteEntityManager,
        QuoteRepositoryInterface $quoteRepository,
        QuoteConfig $config,
        array $quoteDeleteBeforePlugins
    ) {
        $this->quoteEntityManager = $quoteEntityManager;
        $this->quoteRepository = $quoteRepository;
        $this->quoteDeleteBeforePlugins = $quoteDeleteBeforePlugins;
        $this->config = $config;
    }

    /**
     * @return void
     */
    public function deleteExpiredSuccessOrderQuote(): void
    {
        do {
            $quoteCollectionTransfer = $this->findExpiredSuccessOrderQuotes();

            foreach ($quoteCollectionTransfer->getQuotes() as $quoteTransfer) {
                $this->getTransactionHandler()->handleTransaction(function () use ($quoteTransfer) {
                    $this->executeDeleteTransaction($quoteTransfer);
                });
            }
        } while ($quoteCollectionTransfer->getQuotes()->count());
    }

    /**
     * @return \Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    protected function findExpiredSuccessOrderQuotes(): QuoteCollectionTransfer
    {
        $lifetime = $this->config->getSuccessOrderQuoteLifeTime();
        $lifetimeInterval = new DateInterval($lifetime);
        $lifetimeLimitDate = (new DateTime())->sub($lifetimeInterval);

        return $this->quoteRepository->findExpiredSuccessOrderQuotes($lifetimeLimitDate, static::BATCH_SIZE_LIMIT);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return void
     */
    protected function executeDeleteTransaction(QuoteTransfer $quoteTransfer): void
    {
        $quoteTransfer = $this->executeDeleteBeforePlugins($quoteTransfer);
        $this->quoteEntityManager->deleteQuoteById($quoteTransfer->getIdQuote());
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    protected function executeDeleteBeforePlugins(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        foreach ($this->quoteDeleteBeforePlugins as $quoteDeleteBeforePlugin) {
            $quoteTransfer = $quoteDeleteBeforePlugin->execute($quoteTransfer);
        }

        return $quoteTransfer;
    }
}
