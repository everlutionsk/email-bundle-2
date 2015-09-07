<?php

namespace Everlution\EmailBundle\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Everlution\EmailBundle\Message\Template\Parameter;
use Everlution\EmailBundle\Message\Template\Template;

class TemplateType extends Type
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
     * @param Template                                     $value    The value to convert.
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform The currently used database platform.
     *
     * @return string The database representation of the value.
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        return json_encode($this->convertTemplateToArray($value));
    }

    /**
     * @param Template $template
     * @return array
     */
    protected function convertTemplateToArray(Template $template)
    {
        return [
            'name' => $template->getName(),
            'parameters' => $this->convertParametersToArrays($template->getParameters())
        ];
    }

    /**
     * @param Parameter[] $parameters
     * @return array
     */
    protected function convertParametersToArrays(array $parameters)
    {
        return array_map(function(Parameter $parameter) {
            return [
                'name' => $parameter->getName(),
                'value' => $parameter->getValue()
            ];
        }, $parameters);
    }

    /**
     * Converts a value from its database representation to its PHP representation
     * of this type.
     *
     * @param string                                    $value    The value to convert.
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform The currently used database platform.
     *
     * @return Template The PHP representation of the value.
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        $rawTemplate = json_decode($value, true);

        return $this->convertArrayToTemplate($rawTemplate);
    }

    /**
     * @param array $rawTemplate
     * @return Template
     */
    protected function convertArrayToTemplate(array $rawTemplate)
    {
        return new Template(
            $rawTemplate['name'],
            $this->convertArraysToParameters($rawTemplate['parameters'])
        );
    }

    /**
     * @param array $rawParameters
     * @return Parameter[]
     */
    protected function convertArraysToParameters(array $rawParameters)
    {
        return array_map(function($rawParameter) {
            return new Parameter($rawParameter['name'], $rawParameter['value']);
        }, $rawParameters);
    }

    /**
     * Gets the name of this type.
     *
     * @return string
     */
    public function getName()
    {
        return 'emailTemplate';
    }

}
