<?php

namespace Everlution\EmailBundle\Outbound\MessageEvent;

use Everlution\EmailBundle\Support\RequestSignatureVerifier;
use Symfony\Component\HttpFoundation\Request;

interface RequestProcessor extends RequestSignatureVerifier
{

    /**
     * @param Request $request
     * @return MessageEvent[]
     */
    public function createMessageEvents(Request $request);

}
