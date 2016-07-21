<?php

namespace Everlution\EmailBundle\Outbound\Message;

use Everlution\EmailBundle\Attachment\Attachment;
use Everlution\EmailBundle\Message\Header;
use Everlution\EmailBundle\Message\Recipient\Recipient;
use Everlution\EmailBundle\Message\Template\Template;

class OutboundMessage
{

    /** @var string */
    protected $fromName;

    /** @var string */
    protected $fromEmail;

    /** @var string */
    protected $replyTo;

    /** @var string */
    protected $subject;

    /** @var Recipient[] */
    protected $recipients = [];

    /** @var Header[] */
    protected $customHeaders = [];

    /** @var Attachment[] */
    protected $attachments = [];

    /** @var Attachment[] */
    protected $images = [];

    /** @var string */
    protected $text;

    /** @var string */
    protected $html;

    /** @var Template */
    protected $template;

    /** @var string */
    protected $inReplyTo;

    /** @var string */
    protected $references;


    /**
     * @return string
     */
    public function getFromName()
    {
        return $this->fromName;
    }

    /**
     * @param string $fromName
     * @return $this
     */
    public function setFromName($fromName)
    {
        $this->fromName = $fromName;

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
     * @return $this
     */
    public function setFromEmail($fromEmail)
    {
        $this->fromEmail = $fromEmail;

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
     * @return $this
     */
    public function setReplyTo($replyTo)
    {
        $this->replyTo = $replyTo;

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
     * @return $this
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

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
     * @return $this
     */
    public function setRecipients(array $recipients)
    {
        $this->recipients = $recipients;

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
     * @return $this
     */
    public function setCustomHeaders(array $customHeaders)
    {
        $this->customHeaders = $customHeaders;

        return $this;
    }

    /**
     * @return Attachment[]
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @param Attachment[] $attachments
     * @return $this
     */
    public function setAttachments(array $attachments)
    {
        $this->attachments = $attachments;

        return $this;
    }

    /**
     * @return Attachment[]
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param Attachment[] $images
     * @return $this
     */
    public function setImages(array $images)
    {
        $this->images = $images;

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
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

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
     * @return $this
     */
    public function setHtml($html)
    {
        $this->html = $html;

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
     * @return $this
     */
    public function setTemplate($template)
    {
        $this->template = $template;

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
     * @return $this
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
     * @return $this
     */
    public function setReferences($references)
    {
        $this->references = $references;

        return $this;
    }

}
