<?php

declare(strict_types=1);

/**
 * Class ResendAsynchronouslyException
 *
 * @author Martin Adamik <martin.adamik@everlution.sk>
 */
class ResendAsynchronouslyException extends \Exception
{
    /**
     * ResendAsynchronouslyException constructor.
     */
    public function __construct()
    {
        parent::__construct(
            'Resend action cannot be used asynchronously.'
        );
    }
}
