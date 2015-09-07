<?php

namespace Everlution\EmailBundle\Inbound;

use Everlution\EmailBundle\Inbound\Message\InboundMessage;
use Everlution\EmailBundle\Support\RequestSignatureVerifier;
use Symfony\Component\HttpFoundation\Request;

interface RequestProcessor extends RequestSignatureVerifier
{

    /**
     * @param Request $request
     * @return InboundMessage[]
     */
    public function createInboundMessages(Request $request);

}
