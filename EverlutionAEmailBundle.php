<?php

namespace Everlution\EmailBundle;

use Doctrine\DBAL\Types\Type;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EverlutionEmailBundle extends Bundle
{

    /**
     * Boots the Bundle.
     */
    public function boot()
    {
        $this->registerCustomDoctrineTypes();
    }

    protected function registerCustomDoctrineTypes()
    {
        Type::addType('storableOutcomingMessageStatus', 'Everlution\EmailBundle\Doctrine\Type\StorableOutcomingMessageStatus');
    }
}
