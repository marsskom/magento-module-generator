<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Php\Heap;

use Marsskom\Generator\Api\Data\ContextInterface;
use Marsskom\Generator\Model\Php\Foundation\AbstractSequence;
use Nette\PhpGenerator\ClassType;
use function implode;

class ClassGenerator extends AbstractSequence
{
    /**
     * @inheritdoc
     */
    public function execute(ContextInterface $context): ContextInterface
    {
        $input = $context->input()->classCxt();

        $class = new ClassType($input->getClassName());

        if ($input->hasExtends()) {
            $class->setExtends($input->getExtends());
        }

        if ($input->hasImplements()) {
            $class->setImplements($input->getImplements());
        }

        if ($input->hasComments()) {
            $class->addComment(implode("\n", $input->getComments()));
        }

        $context->output()->setState($class);

        return $context;
    }
}
