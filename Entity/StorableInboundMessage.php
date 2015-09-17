<?php

namespace Everlution\EmailBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Everlution\EmailBundle\Message\Header;
use Everlution\EmailBundle\Inbound\Message\InboundMessage;
use Everlution\EmailBundle\Message\IdentifiableMessage;
use Everlution\EmailBundle\Relationship\ReplyableMessage;
use Everlution\EmailBundle\Message\Recipient\Recipient;

/**
 * @ORM\Entity(repositoryClass="Everlution\EmailBundle\Entity\Repository\StorableInboundMessage")
 * @ORM\Table(name="email_inbound", indexes={
 *          @ORM\Index(name="message_idx", columns={"message_id"})
 *      })
 */
class StorableInboundMessage implements ReplyableMessage
{

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="message_id", type="string", length=255, nullable=false, unique=true)
     */
    protected $messageId;

    /**
     * @var string
     * @ORM\Column(name="in_reply_to", type="string", length=255, nullable=true)
     */
    protected $inReplyTo;

    /**
     * @var string
     *
     * @ORM\Column(name="parents", type="string", nullable=true)
     */
    protected $references;

    /**
     * @var Recipient[]
     *
     * @ORM\Column(name="recipients", type="emailRecipients", nullable=false)
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
     * @ORM\Column(name="html", type="text", nullable=true)
     */
    protected $html;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    protected $text;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", nullable=false)
     */
    protected $subject;

    /**
     * @var Header[]
     *
     * @ORM\Column(name="headers", type="emailHeaders", nullable=true)
     */
    protected $headers;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="delivered_at", type="datetime", nullable=false)
     */
    protected $deliveredAt;

    /**
     * @param InboundMessage $message
     */
    public function __construct(InboundMessage $message)
    {
        $this->messageId = $message->getMessageId();
        $this->inReplyTo = $message->getInReplyTo();
        $this->references = $message->getReferences();
        $this->recipients = $message->getRecipients();
        $this->replyTo = $message->getReplyTo();
        $this->fromEmail = $message->getFromEmail();
        $this->fromName = $message->getFromName();
        $this->html = $message->getHtml();
        $this->text = $message->getText();
        $this->subject = $message->getSubject();
        $this->headers = $message->getHeaders();

        $this->deliveredAt = new DateTime('now');
    }

    /**
     * @return int
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
     * @return StorableInboundMessage
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
     * @return StorableInboundMessage
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
     * @return StorableInboundMessage
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
     * @return StorableInboundMessage
     */
    public function setRecipients($recipients)
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
     * @return StorableInboundMessage
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
     * @return StorableInboundMessage
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
     * @return StorableInboundMessage
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
     * @return StorableInboundMessage
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
     * @return StorableInboundMessage
     */
    public function setText($text)
    {
        $this->text = $text;

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
     * @return StorableInboundMessage
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return Header[]
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param Header[] $headers
     * @return StorableInboundMessage
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDeliveredAt()
    {
        return $this->deliveredAt;
    }

    /**
     * @param DateTime $deliveredAt
     * @return StorableInboundMessage
     */
    public function setDeliveredAt($deliveredAt)
    {
        $this->deliveredAt = $deliveredAt;

        return $this;
    }

    /**
     * @param IdentifiableMessage $message
     * @return bool
     */
    public function isReplyTo(IdentifiableMessage $message)
    {
        return ($this->inReplyTo === $message->getMessageId());
    }

}
