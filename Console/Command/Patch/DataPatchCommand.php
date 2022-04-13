<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Console\Command\Patch;

use Marsskom\Generator\Console\Command\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class DataPatchCommand extends GeneratorCommand
{
    /**
     * @inheritdoc
     */
    protected function configure(): void
    {
        $this->setName('generate:patch:data');
        $this->setDescription("Generates data patch class.");
        $this->setDefinition($this->getOptionsList());

        parent::configure();
    }

    /**
     * Returns command options list.
     *
     * @return array
     */
    protected function getOptionsList(): array
    {
        return [
            new InputOption(
                'module',
                null,
                InputOption::VALUE_REQUIRED,
                'Module name (Vendor_Module)'
            ),
            new InputOption(
                'name',
                null,
                InputOption::VALUE_REQUIRED,
                'Class name'
            ),
            new InputOption(
                'path',
                null,
                InputOption::VALUE_OPTIONAL,
                'File location',
                'Setup/Patch/Data'
            ),
        ];
    }
}
