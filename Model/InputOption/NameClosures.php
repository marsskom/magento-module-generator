<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\InputOption;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Model\Enum\InputParameter;
use function ucwords;

/**
 * phpcs:disable Magento2.Functions.StaticFunction
 */
class NameClosures
{
    /**
     * Converts id name ("some-name") into class name ("SomeName").
     *
     * @param ScopeInterface $scope
     *
     * @return string
     */
    public static function idNameToClassName(ScopeInterface $scope): string
    {
        $name = $scope->input()->get(InputParameter::NAME);
        if (empty($name)) {
            return (string) $name;
        }

        return str_replace(
            ' ',
            '',
            ucwords(
                str_replace(['-', '_'], ' ', $name)
            )
        );
    }
}
