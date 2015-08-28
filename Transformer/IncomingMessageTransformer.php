<?php

namespace Everlution\EmailBundle\Transformer;

use Everlution\EmailBundle\Message\Incoming\IncomingMessage;

interface IncomingMessageTransformer
{

    /**
     * @param IncomingMessage $message
     * @return IncomingMessage
     */
    public function transform(IncomingMessage $message);

}
