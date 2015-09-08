<?php

namespace Everlution\EmailBundle\Controller;

use Everlution\EmailBundle\Inbound\MessageProcessor;
use Everlution\EmailBundle\Inbound\RequestProcessor;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class InboundController extends BaseController
{

    /** @var RequestProcessor */
    protected $requestProcessor;

    /** @var MessageProcessor */
    protected $messageProcessor;

    /**
     * @param RequestProcessor $requestProcessor
     * @param MessageProcessor $messageProcessor
     */
    public function __construct(RequestProcessor $requestProcessor, MessageProcessor $messageProcessor)
    {
        $this->requestProcessor = $requestProcessor;
        $this->messageProcessor = $messageProcessor;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function handleInbound(Request $request)
    {
        if (!$this->requestProcessor->isRequestSignatureCorrect($request)) {
            return $this->createAccessDeniedResponse();
        }

        $this->storeInboundMessages($request);

        return $this->createSuccessResponse();
    }

    /**
     * @param Request $request
     */
    protected function storeInboundMessages(Request $request)
    {
        $messages = $this->requestProcessor->createInboundMessages($request);

        foreach ($messages as $message) {
            $this->messageProcessor->storeInboundMessage($message);
        }
    }

}
