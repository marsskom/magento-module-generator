<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Mock\Automation;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Model\Foundation\AbstractSequence;
use Marsskom\Generator\Test\Unit\Mock\TemplateEngine\TemplateFromArray;

class WriterIntoTemplateFromArray extends AbstractSequence
{
    /**
     * @inheritdoc
     */
    public function execute(ScopeInterface $scope): ScopeInterface
    {
        $scope->context()->setTemplate(
            new TemplateFromArray($scope->var()->getAll())
        );

        return $scope;
    }
}
