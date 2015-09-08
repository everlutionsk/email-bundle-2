<?php

namespace Everlution\EmailBundle\Controller;

use InvalidArgumentException;
use Everlution\EmailBundle\Outbound\MessageEvent\MessageEventProcessor;
use Everlution\EmailBundle\Outbound\MessageEvent\RequestProcessor;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MessageEventController extends BaseController
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
    public function handleMessageEvent(Request $request)
    {
        if (!$this->requestProcessor->isRequestSignatureCorrect($request)) {
            return $this->createAccessDeniedResponse();
        }

        $this->changeMessagesState($request);

        return $this->createSuccessResponse();
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
            } catch (InvalidArgumentException $e) {
                // Ignores an exception, because there is the possibility of a situation in which an event
                // occurs earlier than the message is stored in database!
            }
        }
    }

}
