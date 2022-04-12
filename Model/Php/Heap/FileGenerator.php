<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Php\Heap;

use Marsskom\Generator\Api\Data\ContextInterface;
use Marsskom\Generator\Model\Php\Foundation\AbstractSequence;
use Nette\PhpGenerator\PhpFile;

class FileGenerator extends AbstractSequence
{
    /**
     * @inheritdoc
     */
    public function execute(ContextInterface $context): ContextInterface
    {
        $file = new PhpFile();
        $file->setStrictTypes();

        $namespace = $file->addNamespace($context->input()->file()->getNamespace());

        if ($context->input()->file()->hasUses()) {
            foreach ($context->input()->file()->getUses() as $use) {
                $namespace->addUse($use->getName(), $use->getAlias(), $use->getType());
            }
        }

        $context->output()->setState($file);

        return $context;
    }
}
