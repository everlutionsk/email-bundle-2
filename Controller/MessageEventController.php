<?php

namespace Everlution\EmailBundle\Controller;

use Everlution\EmailBundle\Outbound\MessageEvent\MessageEventProcessor;
use Everlution\EmailBundle\Outbound\MessageEvent\RequestProcessor;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MessageEventController
{

    /** @var RequestProcessor */
    protected $requestProcessor;

    /** @var MessageEventProcessor */
    protected $messageEventProcessor;

    /**
     * @param RequestProcessor $requestProcessor
     * @param MessageEventProcessor $messageEventProcessor
     */
    public function __construct(RequestProcessor $requestProcessor, MessageEventProcessor $messageEventProcessor)
    {
        $this->requestProcessor = $requestProcessor;
        $this->messageEventProcessor = $messageEventProcessor;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function handleMessageEventAction(Request $request)
    {
        if (!$this->requestProcessor->isRequestSignatureCorrect($request)) {
            return new JsonResponse(['status' => 'error', 'msg' => 'Access Denied! Invalid request signature.'], 403);
        }

        $this->changeMessagesState($request);

        return new JsonResponse(['status' => 'success'], 200);
    }

    /**
     * @param Request $request
     */
    protected function changeMessagesState(Request $request)
    {
        $events = $this->requestProcessor->createMessageEvents($request);

        foreach ($events as $event) {
            try {
                $this->messageEventProcessor->changeMessageState($event);
            } catch (\InvalidArgumentException $e) {
                //TODO
            }
        }
    }

}
