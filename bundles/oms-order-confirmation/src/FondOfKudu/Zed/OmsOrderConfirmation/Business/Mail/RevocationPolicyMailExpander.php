<?php

namespace FondOfKudu\Zed\OmsOrderConfirmation\Business\Mail;

use FondOfKudu\Zed\OmsOrderConfirmation\OmsOrderConfirmationConfig;
use Generated\Shared\Transfer\MailAttachmentTransfer;
use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\OrderTransfer;

class RevocationPolicyMailExpander implements RevocationPolicyMailExpanderInterface
{
    /**
     * @var \FondOfKudu\Zed\OmsOrderConfirmation\OmsOrderConfirmationConfig
     */
    protected OmsOrderConfirmationConfig $config;

    /**
     * @param \FondOfKudu\Zed\OmsOrderConfirmation\OmsOrderConfirmationConfig $config
     */
    public function __construct(OmsOrderConfirmationConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\MailTransfer
     */
    public function expandOrderMailTransfer(MailTransfer $mailTransfer, OrderTransfer $orderTransfer): MailTransfer
    {
        $this->setRevocationPolicy($mailTransfer);

        return $mailTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return void
     */
    protected function setRevocationPolicy(MailTransfer $mailTransfer): void
    {
        $revocationPolicyByLocale = $this->config->getRevocationPolicyUrl();
        $localeName = $mailTransfer->getLocale()->getLocaleName();

        if (!array_key_exists($localeName, $revocationPolicyByLocale)) {
            return;
        }

        if (!$revocationPolicyByLocale[$localeName] || !file_exists($revocationPolicyByLocale[$localeName])) {
            return;
        }

        $this->addAttachment($mailTransfer, $revocationPolicyByLocale[$localeName]);
    }

    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     * @param string $attachmentUrl
     *
     * @return void
     */
    protected function addAttachment(MailTransfer $mailTransfer, string $attachmentUrl): void
    {
        $attachments = $mailTransfer->getAttachments();

        $attachment = (new MailAttachmentTransfer())->setAttachmentUrl($attachmentUrl);
        $attachments->append($attachment);

        $mailTransfer->setAttachments($attachments);
    }
}
