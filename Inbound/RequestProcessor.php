<?php

namespace Everlution\EmailBundle\Inbound;

use Everlution\EmailBundle\Message\Inbound\InboundMessage;
use Symfony\Component\HttpFoundation\Request;

interface RequestProcessor
{

    /**
     * @param Request $request
     * @return InboundMessage[]
     */
    public function createInboundMessages(Request $request);

    /**
     * @param Request $request
     * @return bool
     */
    public function isRequestSignatureCorrect(Request $request);

}
