<?php

namespace Everlution\EmailBundle\Doctrine\Type;

class StorableOutboundMessageStatus extends Enum
{

    const FRESH = 'fresh';
    const SCHEDULED = 'scheduled';
    const SENT = 'sent';
    const FAILED = 'failed';
    const RECEIVED = 'received';

    /**
     * Gets array of possible values
     *
     * @return array
     */
    protected function getAllowedValues()
    {
        return [static::FRESH, static::SCHEDULED, static::SENT, static::FAILED, static::RECEIVED];
    }

    /**
     * Gets the name of this type.
     *
     * @return string
     */
    public function getName()
    {
        return 'storableOutboundMessageStatus';
    }

}
