<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Infrastructure\Model\TemplateEngine\Mustache;

use Marsskom\Generator\Domain\Exception\Observer\EventNameNotExistsException;
use Marsskom\Generator\Domain\Observer\Subject;
use Marsskom\Generator\Domain\ValueObject;

class Param extends Subject
{
    public const PREPARE_VARIABLES_EVENT = __CLASS__ . '-prepare_variables_event';

    private string $stubName;

    private array $variables;

    /**
     * Param constructor.
     *
     * @param string $stubName
     * @param array  $variables
     */
    public function __construct(string $stubName, array $variables)
    {
        $this->stubName = $stubName;
        $this->variables = $variables;

        $this->attach(self::PREPARE_VARIABLES_EVENT, new ParamObserver());
    }

    /**
     * Returns stub name.
     *
     * @return string
     */
    public function stubName(): string
    {
        return $this->stubName;
    }

    /**
     * Returns variables.
     *
     * @return array
     *
     * @throws EventNameNotExistsException
     */
    public function variables(): array
    {
        $this->trigger(
            self::PREPARE_VARIABLES_EVENT,
            new ValueObject($this->variables)
        );

        return $this->variables;
    }

    /**
     * Sets variables.
     *
     * @param array $variables
     *
     * @return void
     */
    public function setVariables(array $variables): void
    {
        $this->variables = $variables;
    }
}
