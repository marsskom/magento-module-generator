<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Mock\Sequence;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Foundation\AbstractSequence;

class CoupleContextRegister extends AbstractSequence
{
    /**
     * @var array<string, array>
     */
    private array $additionalContexts;

    /**
     * Couple context register constructor.
     *
     * @param array<string, array> $additionalContexts
     * @param array                $sequences
     */
    public function __construct(
        array $additionalContexts,
        array $sequences = []
    ) {
        parent::__construct($sequences);

        $this->additionalContexts = $additionalContexts;
    }

    /**
     * @inheritdoc
     */
    public function execute(ScopeInterface $scope): ScopeInterface
    {
        $originalScope = clone $scope;

        foreach ($this->additionalContexts as $alias => $userInput) {
            $scope->context()->setPath($userInput[InputParameter::PATH]);
            $scope->context()->setFileName($userInput[InputParameter::NAME]);

            $originalScope->registerContext(clone $scope->context(), $alias);
        }

        // Adds default context.
        $defaultContext = clone (new FakeContextRegister())->execute($scope)->context();
        $originalScope->registerContext($defaultContext);
        $originalScope->setCurrentContext($defaultContext);

        return $originalScope;
    }
}
