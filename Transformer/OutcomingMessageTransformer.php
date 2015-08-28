<?php

namespace Everlution\EmailBundle\Transformer;

use Everlution\EmailBundle\Message\Outcoming\OutcomingMessage;

interface OutcomingMessageTransformer
{

    /**
     * @param OutcomingMessage $message
     * @return OutcomingMessage
     */
    public function transform(OutcomingMessage $message);

}
