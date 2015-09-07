<?php

namespace Everlution\EmailBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Everlution\EmailBundle\Outbound\MailSystem\MailSystemMessageInfo;
use Everlution\EmailBundle\Message\Recipient\Recipient;

/**
 * @ORM\Entity(repositoryClass="Everlution\EmailBundle\Entity\Repository\StorableOutboundMessageInfo")
 * @ORM\Table(name="email_outbound_message_info", indexes={
 *          @ORM\Index(name="search", columns={"email_outbound_id", "mail_system_message_id"}),
 *      })
 * @ORM\HasLifecycleCallbacks
 */
class StorableOutboundMessageInfo
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var StorableOutboundMessage
     *
     * @ORM\ManyToOne(targetEntity="Everlution\EmailBundle\Entity\StorableOutboundMessage", inversedBy="messagesInfo")
     * @ORM\JoinColumn(name="email_outbound_id", referencedColumnName="id")
     **/
    protected $storableOutboundMessage;

    /**
     * Message identifier within the mail system.
     *
     * @var string
     *
     * @ORM\Column(name="mail_system_message_id", type="string", length=255, nullable=false)
     */
    protected $mailSystemMessageId;

    /**
     * @var string
     * @ORM\Column(type="string", length=32, nullable=false)
     */
    protected $status;

    /**
     * @var string
     *
     * @ORM\Column(name="reject_reason", type="string", length=512, nullable=true)
     */
    protected $rejectReason;

    /**
     * @var Recipient
     *
     * @ORM\Column(name="recipient", type="emailRecipient", nullable=false)
     */
    protected $recipient;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    protected $updatedAt;

    /**
     * @param StorableOutboundMessage $storableOutboundMessage
     * @param MailSystemMessageInfo $mailSystemMessage
     */
    public function __construct(StorableOutboundMessage $storableOutboundMessage, MailSystemMessageInfo $mailSystemMessage)
    {
        $this->storableOutboundMessage = $storableOutboundMessage;

        $this->mailSystemMessageId = $mailSystemMessage->getMailSystemMessageId();
        $this->status = $mailSystemMessage->getStatus();
        $this->rejectReason = $mailSystemMessage->getRejectReason();
        $this->recipient = $mailSystemMessage->getRecipient();
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->updatedAt = new \DateTime('now');
    }

    /**
     * @return StorableOutboundMessage
     */
    public function getStorableOutboundMessage()
    {
        return $this->storableOutboundMessage;
    }

    /**
     * @return string
     */
    public function getMailSystemMessageId()
    {
        return $this->mailSystemMessageId;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return StorableOutboundMessageInfo
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getRejectReason()
    {
        return $this->rejectReason;
    }

    /**
     * @param string $rejectReason
     * @return StorableOutboundMessageInfo
     */
    public function setRejectReason($rejectReason)
    {
        $this->rejectReason = $rejectReason;

        return $this;
    }

    /**
     * @return Recipient
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

}
