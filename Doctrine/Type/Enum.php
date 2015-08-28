<?php

namespace Everlution\EmailBundle\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

abstract class Enum extends Type
{

    /**
     * Converts a value from its PHP representation to its database representation
     * of this type.
     *
     * @param mixed                                     $value    The value to convert.
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform The currently used database platform.
     *
     * @return mixed The database representation of the value.
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!in_array($value, $this->getAllowedValues())) {
            $allowedValues = implode(', ', $this->getAllowedValues());
            throw new \InvalidArgumentException("Invalid value [{$this->getName()}]! Allowed values are: [$allowedValues]");
        }

        return $value;
    }

    /**
     * Gets the SQL declaration snippet for a field of this type.
     *
     * @param array                                     $fieldDeclaration The field declaration.
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform         The currently used database platform.
     *
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        $values = array_map(function ($val) {
            return "'$val'";
        }, $this->getAllowedValues());

        $implodedValues = implode(', ', $values);

        return "ENUM($implodedValues) COMMENT '(DC2Type:{$this->getName()})'";
    }

    /**
     * Gets array of possible values
     *
     * @return array
     */
    abstract protected function getAllowedValues();

}
