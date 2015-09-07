<?php

namespace Everlution\EmailBundle\Outbound\Message;

interface OutboundMessageTransformer
{

    /**
     * @param OutboundMessage $message
     */
    public function transform(OutboundMessage $message);

}
