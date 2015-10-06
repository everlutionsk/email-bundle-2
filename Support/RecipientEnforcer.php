<?php

namespace Everlution\EmailBundle\Support;

use Everlution\EmailBundle\Message\Recipient\ToRecipient;
use Everlution\EmailBundle\Outbound\Message\OutboundMessage;
use Everlution\EmailBundle\Outbound\Message\OutboundMessageTransformer;

class RecipientEnforcer implements OutboundMessageTransformer
{

    /** @var string|null */
    protected $enforcedDeliveryAddress;

    /**
     * @param null|string $enforcedDeliveryAddress
     */
    public function __construct($enforcedDeliveryAddress = null)
    {
        $this->enforcedDeliveryAddress = $enforcedDeliveryAddress;
    }

    /**
     * @param OutboundMessage $message
     */
    public function transform(OutboundMessage $message)
    {
        if ($this->enforcedDeliveryAddress !== null) {
            $message->setRecipients([
                new ToRecipient($this->enforcedDeliveryAddress)
            ]);
        }
    }

}
