<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\InputParser\Entity;

use Marsskom\Generator\Api\Data\Input\ParserInterface;
use Marsskom\Generator\Exception\Entity\PropertyStringIsInvalidException;
use Marsskom\Generator\Model\Entity\Property;
use function array_filter;
use function array_map;
use function explode;
use function strpos;

class PropertiesParser implements ParserInterface
{
    public const PROPERTY_DELIMITER = ';';

    public const PROPERTY_OPTION_DELIMITER = ':';

    public const PROPERTY_TYPE_DELIMITER = '|';

    public const SETTER_CHAR = 's';

    public const GETTER_CHAR = 'g';

    public const CONSTRUCTOR_CHAR = 'c';

    /**
     * @inheritdoc
     *
     * @return Property[]
     *
     * @throws PropertyStringIsInvalidException
     */
    public function parse(string $inputValue): array
    {
        $properties = [];
        foreach ($this->getProperties($inputValue) as $propertyString) {
            $chunks = $this->getChunks($propertyString);
            $settersGetters = $chunks[2] ?? '';

            $properties[] = new Property(
                $this->validateName($chunks[0]),
                $this->validateTypes($chunks[1]),
                false !== strpos($settersGetters, self::SETTER_CHAR),
                false !== strpos($settersGetters, self::GETTER_CHAR),
                false !== strpos($settersGetters, self::CONSTRUCTOR_CHAR),
            );
        }

        return $properties;
    }

    /**
     * Returns properties strings.
     *
     * @param string $inputValue
     *
     * @return string[]
     */
    protected function getProperties(string $inputValue): array
    {
        return array_filter(
            explode(
                self::PROPERTY_DELIMITER,
                $inputValue . self::PROPERTY_DELIMITER
            )
        );
    }

    /**
     * Returns property chunks.
     *
     * @param string $propertyString
     *
     * @return array
     *
     * @throws PropertyStringIsInvalidException
     */
    protected function getChunks(string $propertyString): array
    {
        if (false === strpos($propertyString, self::PROPERTY_OPTION_DELIMITER)) {
            throw new PropertyStringIsInvalidException(__("Property string '%1' is invalid", $propertyString));
        }

        $chunks = explode(self::PROPERTY_OPTION_DELIMITER, $propertyString);
        if (count($chunks) < 2) {
            throw new PropertyStringIsInvalidException(__("Property string '%1' is invalid", $propertyString));
        }

        return $chunks;
    }

    /**
     * Validates and returns name.
     *
     * @param string $name
     *
     * @return string
     *
     * @throws PropertyStringIsInvalidException
     */
    protected function validateName(string $name): string
    {
        if (!$this->validate($name)) {
            throw new PropertyStringIsInvalidException(__("Property name '%1' is invalid", $name));
        }

        return $name;
    }

    /**
     * Validates and returns types.
     *
     * @param string $types
     *
     * @return array
     *
     * @throws PropertyStringIsInvalidException
     */
    protected function validateTypes(string $types): array
    {
        $filteredTypes = array_filter(
            explode(
                self::PROPERTY_TYPE_DELIMITER,
                $types . self::PROPERTY_TYPE_DELIMITER
            )
        );

        array_map(function ($type) {
            if (!$this->validate($type)) {
                throw new PropertyStringIsInvalidException(__("Property's type '%2' is invalid", $type));
            }
        }, $filteredTypes);

        return $filteredTypes;
    }

    /**
     * Validates property name or type string.
     *
     * @param string $inputString
     *
     * @return bool
     */
    protected function validate(string $inputString): bool
    {
        if ('?' === $inputString) {
            return true;
        }

        return (bool) preg_match('/^[A-Za-z]\w+?$/', $inputString);
    }
}
