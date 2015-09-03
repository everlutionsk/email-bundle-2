<?php

namespace Everlution\EmailBundle\Controller;

use Everlution\EmailBundle\Inbound\MessageProcessor;
use Everlution\EmailBundle\Inbound\RequestProcessor;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class InboundController
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
    public function handleInboundAction(Request $request)
    {
        if (!$this->requestProcessor->isRequestSignatureCorrect($request)) {
            return new JsonResponse(['status' => 'error', 'msg' => 'Access Denied! Invalid request signature.'], 403);
        }

        $this->storeInboundMessages($request);

        return new JsonResponse(['status' => 'success'], 200);
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
