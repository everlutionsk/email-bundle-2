<?php

namespace Everlution\EmailBundle\Transformer;

use Everlution\EmailBundle\Message\Inbound\InboundMessage;

interface InboundMessageTransformer
{

    /**
     * @param InboundMessage $message
     */
    public function transform(InboundMessage $message);

}
