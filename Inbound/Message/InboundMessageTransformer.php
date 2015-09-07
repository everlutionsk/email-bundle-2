<?php

namespace Everlution\EmailBundle\Inbound\Message;

interface InboundMessageTransformer
{

    /**
     * @param InboundMessage $message
     */
    public function transform(InboundMessage $message);

}
