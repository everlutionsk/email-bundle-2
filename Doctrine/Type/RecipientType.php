<?php

namespace Everlution\EmailBundle\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Everlution\EmailBundle\Message\Recipient\Recipient;

class RecipientType extends Type
{

    /**
     * Gets the SQL declaration snippet for a field of this type.
     *
     * @param array $fieldDeclaration The field declaration.
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform The currently used database platform.
     *
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getClobTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * Converts a value from its PHP representation to its database representation
     * of this type.
     *
     * @param Recipient                                     $value    The value to convert.
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform The currently used database platform.
     *
     * @return string The database representation of the value.
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        return json_encode($this->convertRecipientToArray($value));
    }

    /**
     * @param Recipient $recipient
     * @return array
     */
    protected function convertRecipientToArray(Recipient $recipient)
    {
        return [
            'type' => $recipient->getType(),
            'email' => $recipient->getEmail(),
            'name' => $recipient->getName()
        ];
    }

    /**
     * Converts a value from its database representation to its PHP representation
     * of this type.
     *
     * @param string                                    $value    The value to convert.
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform The currently used database platform.
     *
     * @return Recipient The PHP representation of the value.
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        $rawRecipient = json_decode($value, true);

        return $this->convertArrayToRecipient($rawRecipient);
    }

    /**
     * @param array $rawRecipient
     * @return Recipient
     */
    protected function convertArrayToRecipient(array $rawRecipient)
    {
        return new Recipient(
            $rawRecipient['email'],
            $rawRecipient['name'],
            $rawRecipient['type']
        );
    }

    /**
     * Gets the name of this type.
     *
     * @return string
     */
    public function getName()
    {
        return 'emailRecipient';
    }

}
