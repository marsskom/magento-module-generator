<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Console\Command;

class ModuleCommand extends GeneratorCommand
{
    /**
     * @inheritdoc
     */
    protected function configure(): void
    {
        $this->setName('generate:module');
        $this->setDescription("Generates module.");

        parent::configure();
    }
}
