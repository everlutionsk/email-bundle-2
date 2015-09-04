<?php

namespace Everlution\EmailBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class BaseController
{

    /**
     * @return JsonResponse
     */
    protected function createAccessDeniedResponse()
    {
        return new JsonResponse(['status' => 'error', 'msg' => 'Access Denied! Invalid request signature.'], 403);
    }

    /**
     * @return JsonResponse
     */
    protected function createSuccessResponse()
    {
        return new JsonResponse(['status' => 'success'], 200);
    }

}
