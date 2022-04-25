<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Automation\Writer;

use Magento\Framework\Exception\FileSystemException;
use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Model\Foundation\AbstractSequence;

class ScopeWriter extends AbstractSequence
{
    private ContextWriter $contextWriter;

    /**
     * @inheritdoc
     *
     * @param ContextWriter $contextWriter
     */
    public function __construct(
        ContextWriter $contextWriter,
        array $sequences = []
    ) {
        parent::__construct($sequences);

        $this->contextWriter = $contextWriter;
    }

    /**
     * @inheritdoc
     *
     * @throws FileSystemException
     */
    public function execute(ScopeInterface $scope): ScopeInterface
    {
        foreach ($scope->walk() as $concreteScope) {
            $this->contextWriter->execute($concreteScope);
        }

        return $scope;
    }
}
