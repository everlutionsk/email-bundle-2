<?php

namespace Everlution\EmailBundle\Outbound\MessageEvent;

use Symfony\Component\HttpFoundation\Request;

interface RequestProcessor
{

    /**
     * @param Request $request
     * @return MessageEvent[]
     */
    public function createMessageEvents(Request $request);

    /**
     * @param Request $request
     * @return bool
     */
    public function isRequestSignatureCorrect(Request $request);

}
