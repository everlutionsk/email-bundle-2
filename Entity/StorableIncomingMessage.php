<?php

namespace Everlution\EmailBundle\Entity;

use DateTime;
use Everlution\EmailBundle\Header;
use Everlution\EmailBundle\Message\ReplyableMessage;
use Everlution\EmailBundle\Recipient\Recipient;

/**
 * @ORM\Entity()
 * @ORM\Table(name="email_incoming", repositoryClass="Everlution\EmailBundle\Entity\Repository\StorableIncomingMessage", indexes={@ORM\Index(name="message_idx", columns={"message_id"})})
 */
class StorableIncomingMessage implements ReplyableMessage
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
     * @var string
     *
     * @ORM\Column(name="subject", type="string", nullable=false)
     */
    protected $subject;

    /**
     * @var Header[]
     *
     * @ORM\Column(name="headers", type="array", nullable=true)
     */
    protected $headers;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="delivered_at", type="datetime", nullable=false)
     */
    protected $deliveredAt;

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
     * @return StorableIncomingMessage
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
     * @return StorableIncomingMessage
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
     * @return StorableIncomingMessage
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
     * @return StorableIncomingMessage
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
     * @return StorableIncomingMessage
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
     * @return StorableIncomingMessage
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
     * @return StorableIncomingMessage
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
     * @return StorableIncomingMessage
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
     * @return StorableIncomingMessage
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
     * @return StorableIncomingMessage
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
     * @return StorableIncomingMessage
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
     * @return StorableIncomingMessage
     */
    public function setDeliveredAt($deliveredAt)
    {
        $this->deliveredAt = $deliveredAt;

        return $this;
    }

}
