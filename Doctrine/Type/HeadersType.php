<?php

namespace Everlution\EmailBundle\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Everlution\EmailBundle\Message\Header;

class HeadersType extends Type
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
     * @param Header[]                                     $value    The value to convert.
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform The currently used database platform.
     *
     * @return string The database representation of the value.
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        $rawHeaders = array_map(function(Header $header) {
            return $this->convertHeaderToArray($header);
        }, $value);

        return json_encode($rawHeaders);
    }

    /**
     * @param Header $header
     * @return array
     */
    protected function convertHeaderToArray(Header $header)
    {
        return [
            'name' => $header->getName(),
            'value' => $header->getValue(),
        ];
    }

    /**
     * Converts a value from its database representation to its PHP representation
     * of this type.
     *
     * @param string                                    $value    The value to convert.
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform The currently used database platform.
     *
     * @return Header[] The PHP representation of the value.
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        $rawHeaders = json_decode($value, true);

        return array_map(function($rawHeader) {
            return $this->convertArrayToHeader($rawHeader);
        }, $rawHeaders);
    }

    /**
     * @param array $rawHeader
     * @return Header
     */
    protected function convertArrayToHeader(array $rawHeader)
    {
        return new Header(
            $rawHeader['name'],
            $rawHeader['value']
        );
    }

    /**
     * Gets the name of this type.
     *
     * @return string
     */
    public function getName()
    {
        return 'emailHeaders';
    }

}
