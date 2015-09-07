<?php

namespace Everlution\EmailBundle\Support;

use Symfony\Component\HttpFoundation\Request;

interface RequestSignatureVerifier
{

    /**
     * @param Request $request
     * @return bool
     */
    public function isRequestSignatureCorrect(Request $request);

}
