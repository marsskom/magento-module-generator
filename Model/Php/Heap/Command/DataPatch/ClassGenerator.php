<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Php\Heap\Command\DataPatch;

use Marsskom\Generator\Api\Data\ContextInterface;
use Marsskom\Generator\Model\Php\Foundation\AbstractSequence;
use Nette\PhpGenerator\ClassType;

class ClassGenerator extends AbstractSequence
{
    /**
     * @inheritdoc
     */
    public function execute(ContextInterface $context): ContextInterface
    {
        /** @var $class ClassType */
        $class = $context->output()->getState();

        $class->setImplements(['DataPatchInterface']);

        $class->addProperty('moduleDataSetup')
              ->setType('ModuleDataSetupInterface')
              ->setPrivate();

        $constructor = $class->addMethod('__construct')
                             ->addComment($class->getName() . ' constructor')
                             ->addComment('')
                             ->addComment('@param ModuleDataSetupInterface $moduleDataSetup')
                             ->setBody('$this->moduleDataSetup = $moduleDataSetup;');

        $constructor->addParameter('moduleDataSetup')
                    ->setType('ModuleDataSetupInterface');

        $class->addMethod('apply')
              ->addComment('@inheritdoc')
              ->setPublic()
              ->setReturnType('void')
              ->setBody("\$this->moduleDataSetup->getConnection()->startSetup();\n\n// Your code here.\n\n\$this->moduleDataSetup->getConnection()->endSetup();");

        $class->addMethod('getDependencies')
              ->addComment('@inheritdoc')
              ->setPublic()
              ->setStatic()
              ->setReturnType('array')
              ->setBody('return [];');

        $class->addMethod('getAliases')
              ->addComment('@inheritdoc')
              ->setPublic()
              ->setReturnType('array')
              ->setBody('return [];');

        $context->output()->setState($class);

        return $context;
    }
}
