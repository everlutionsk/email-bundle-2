<?php

namespace Everlution\EmailBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Everlution\EmailBundle\Doctrine\Type\StorableOutcomingMessageStatus;
use Everlution\EmailBundle\Header;
use Everlution\EmailBundle\Message\Outcoming\IdentifiableOutcomingMessage;
use Everlution\EmailBundle\Message\ReplyableMessage;
use Everlution\EmailBundle\Recipient\Recipient;
use Everlution\EmailBundle\Template\Template;

/**
 * @ORM\Entity()
 * @ORM\Table(name="email_outcoming", repositoryClass="Everlution\EmailBundle\Entity\Repository\StorableOutcomingMessage", indexes={@ORM\Index(name="message_idx", columns={"message_id"})})
 */
class StorableOutcomingMessage implements ReplyableMessage
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="message_id", type="string", length=255, nullable=false)
     */
    protected $messageId;

    /**
     * @var string
     *
     * @ORM\Column(name="in_reply_to", type="string", length=255, nullable=true)
     */
    protected $inReplyTo;

    /**
     * @var string
     *
     * @ORM\Column(name="references", type="string", nullable=true)
     */
    protected $references;

    /**
     * @var Recipient[]
     *
     * @ORM\Column(name="recipients", type="array", nullable=false)
     */
    protected $recipients;

    /**
     * @var string
     *
     * @ORM\Column(name="reply_to", type="string", length=255, nullable=true)
     */
    protected $replyTo;

    /**
     * @var string
     *
     * @ORM\Column(name="from_email", type="string", length=255, nullable=false)
     */
    protected $fromEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="from_name", type="string", length=255, nullable=true)
     */
    protected $fromName;

    /**
     * @var string
     *
     * @ORM\Column(name="html", type="string", nullable=true)
     */
    protected $html;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", nullable=true)
     */
    protected $text;

    /**
     * @var Template
     *
     * @ORM\Column(name="template", type="object", nullable=true)
     */
    protected $template;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", nullable=false)
     */
    protected $subject;

    /**
     * @var Header[]
     *
     * @ORM\Column(name="custom_headers", type="array", nullable=true)
     */
    protected $customHeaders;

    /**
     * @var string
     * @ORM\Column(type="storableOutcomingMessageStatus", nullable=false)
     */
    protected $status;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="scheduled_send_time", type="datetime", nullable=true)
     */
    protected $scheduledSendTime;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="sent_at", type="datetime", nullable=true)
     */
    protected $sentAt;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_system", type="string", length=255, nullable=false)
     */
    protected $mailSystem;

    /**
     * @var string
     *
     * @ORM\Column(name="error", type="string", length=512, nullable=true)
     */
    protected $error;

    /**
     * @param IdentifiableOutcomingMessage $identifiableMessage
     * @param string $mailSystemName
     */
    public function __construct(IdentifiableOutcomingMessage $identifiableMessage, $mailSystemName)
    {
        $message = $identifiableMessage->getMessage();

        $this->messageId = $identifiableMessage->getMessageId();
        $this->inReplyTo = $message->getInReplyTo();
        $this->references = $message->getReferences();
        $this->recipients = $message->getRecipients();
        $this->replyTo = $message->getReplyTo();
        $this->fromEmail = $message->getFromEmail();
        $this->fromName = $message->getFromName();
        $this->html = $message->getHtml();
        $this->text = $message->getText();
        $this->template = $message->getTemplate();
        $this->subject = $message->getSubject();
        $this->customHeaders = $message->getCustomHeaders();

        $this->status = StorableOutcomingMessageStatus::FRESH;
        $this->createdAt = new DateTime('now');
        $this->mailSystem = $mailSystemName;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * @param string $messageId
     * @return StorableOutcomingMessage
     */
    public function setMessageId($messageId)
    {
        $this->messageId = $messageId;

        return $this;
    }

    /**
     * @return string
     */
    public function getInReplyTo()
    {
        return $this->inReplyTo;
    }

    /**
     * @param string $inReplyTo
     * @return StorableOutcomingMessage
     */
    public function setInReplyTo($inReplyTo)
    {
        $this->inReplyTo = $inReplyTo;

        return $this;
    }

    /**
     * @return string
     */
    public function getReferences()
    {
        return $this->references;
    }

    /**
     * @param string $references
     * @return StorableOutcomingMessage
     */
    public function setReferences($references)
    {
        $this->references = $references;

        return $this;
    }

    /**
     * @return Recipient[]
     */
    public function getRecipients()
    {
        return $this->recipients;
    }

    /**
     * @param Recipient[] $recipients
     * @return StorableOutcomingMessage
     */
    public function setRecipients(array $recipients)
    {
        $this->recipients = $recipients;

        return $this;
    }

    /**
     * @return string
     */
    public function getReplyTo()
    {
        return $this->replyTo;
    }

    /**
     * @param string $replyTo
     * @return StorableOutcomingMessage
     */
    public function setReplyTo($replyTo)
    {
        $this->replyTo = $replyTo;

        return $this;
    }

    /**
     * @return string
     */
    public function getFromEmail()
    {
        return $this->fromEmail;
    }

    /**
     * @param string $fromEmail
     * @return StorableOutcomingMessage
     */
    public function setFromEmail($fromEmail)
    {
        $this->fromEmail = $fromEmail;

        return $this;
    }

    /**
     * @return string
     */
    public function getFromName()
    {
        return $this->fromName;
    }

    /**
     * @param string $fromName
     * @return StorableOutcomingMessage
     */
    public function setFromName($fromName)
    {
        $this->fromName = $fromName;

        return $this;
    }

    /**
     * @return string
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * @param string $html
     * @return StorableOutcomingMessage
     */
    public function setHtml($html)
    {
        $this->html = $html;

        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return StorableOutcomingMessage
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return Template
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param Template $template
     * @return StorableOutcomingMessage
     */
    public function setTemplateContent(Template $template = null)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     * @return StorableOutcomingMessage
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return Header[]
     */
    public function getCustomHeaders()
    {
        return $this->customHeaders;
    }

    /**
     * @param Header[] $customHeaders
     * @return StorableOutcomingMessage
     */
    public function setCustomHeaders(array $customHeaders = null)
    {
        $this->customHeaders = $customHeaders;

        return $this;
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
     * @return StorableOutcomingMessage
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return StorableOutcomingMessage
     */
    public function setCreatedAt(DateTime $createdAt = null)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getScheduledSendTime()
    {
        return $this->scheduledSendTime;
    }

    /**
     * @param DateTime $scheduledSendTime
     * @return StorableOutcomingMessage
     */
    public function setScheduledSendTime(DateTime $scheduledSendTime = null)
    {
        $this->scheduledSendTime = $scheduledSendTime;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getSentAt()
    {
        return $this->sentAt;
    }

    /**
     * @param DateTime $sentAt
     * @return StorableOutcomingMessage
     */
    public function setSentAt(DateTime $sentAt = null)
    {
        $this->sentAt = $sentAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getMailSystem()
    {
        return $this->mailSystem;
    }

    /**
     * @param string $mailSystem
     * @return StorableOutcomingMessage
     */
    public function setMailSystem($mailSystem)
    {
        $this->mailSystem = $mailSystem;

        return $this;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param string $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }

}
