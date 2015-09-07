<?php

namespace Everlution\EmailBundle\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Everlution\EmailBundle\Message\Recipient\Recipient;

class RecipientsType extends RecipientType
{

    /**
     * Converts a value from its PHP representation to its database representation
     * of this type.
     *
     * @param Recipient[]                                     $value    The value to convert.
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform The currently used database platform.
     *
     * @return string The database representation of the value.
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        $rawRecipients = array_map(function(Recipient $recipient) {
            return $this->convertRecipientToArray($recipient);
        }, $value);

        return json_encode($rawRecipients);
    }

    /**
     * Converts a value from its database representation to its PHP representation
     * of this type.
     *
     * @param string                                    $value    The value to convert.
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform The currently used database platform.
     *
     * @return Recipient[] The PHP representation of the value.
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        $rawRecipients = json_decode($value, true);

        return array_map(function($rawRecipient) {
            return $this->convertArrayToRecipient($rawRecipient);
        }, $rawRecipients);

    }

    /**
     * Gets the name of this type.
     *
     * @return string
     */
    public function getName()
    {
        return 'emailRecipients';
    }

}
