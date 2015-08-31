<?php

namespace Everlution\EmailBundle\Transformer;

use Everlution\EmailBundle\Message\Outbound\OutboundMessage;

interface OutboundMessageTransformer
{

    /**
     * @param OutboundMessage $message
     */
    public function transform(OutboundMessage $message);

}
