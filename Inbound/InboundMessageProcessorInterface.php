<?php

namespace Everlution\EmailBundle\Inbound;

use Everlution\EmailBundle\Message\Inbound\InboundMessage;

interface InboundMessageProcessorInterface
{

    /**
     * @param InboundMessage $message
     * @param string $mailSystemName
     */
    public function storeInboundMessage(InboundMessage $message, $mailSystemName);

}
