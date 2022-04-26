<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Automation\Context;

use Marsskom\Generator\Api\Data\Generator\ContextRegisterGeneratorInterface;
use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Model\Foundation\AbstractSequence;
use Marsskom\Generator\Model\Foundation\Sequence;
use Marsskom\Generator\Model\GlobalFactory;

abstract class ContextRegister extends AbstractSequence implements ContextRegisterGeneratorInterface
{
    protected GlobalFactory $globalFactory;

    /**
     * @inhertidoc
     *
     * @param GlobalFactory $globalFactory
     */
    public function __construct(
        GlobalFactory $globalFactory,
        array $sequences = []
    ) {
        parent::__construct($sequences);

        $this->globalFactory = $globalFactory;
    }

    /**
     * @inheritdoc
     */
    public function execute(ScopeInterface $scope): ScopeInterface
    {
        $originalScope = clone $scope;

        $firstContext = null;
        $defaultContext = null;
        foreach ($this->getContexts() as $alias => $sequence) {
            $localSequences = $this->globalFactory->create(Sequence::class, [
                'sequences' => $sequence,
            ]);
            $scope = $localSequences->execute($scope);

            if (null === $firstContext) {
                $firstContext = clone $scope->context();
            }
            if ($alias === ScopeInterface::DEFAULT_CONTEXT) {
                $defaultContext = clone $scope->context();
            }

            $originalScope = $originalScope->registerContext(clone $scope->context(), $alias);
        }

        $originalScope = $originalScope->setCurrentContext($defaultContext ?? $firstContext);
        if (null === $defaultContext) {
            // Register first context as default
            $originalScope = $originalScope->registerContext($firstContext);
        }

        return $originalScope;
    }
}
