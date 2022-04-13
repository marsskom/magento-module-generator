<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Console\Command\Patch;

use Marsskom\Generator\Console\Command\GeneratorCommand;
use Marsskom\Generator\Model\Context\Parameters;
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

        parent::configure();
    }

    /**
     * @inheritdoc
     */
    protected function optionsList(): array
    {
        return [
            new InputOption(
                Parameters::NAME,
                null,
                InputOption::VALUE_REQUIRED,
                'Class name'
            ),
            new InputOption(
                Parameters::PATH,
                null,
                InputOption::VALUE_OPTIONAL,
                'File location',
                'Setup/Patch/Data'
            ),
        ];
    }
}
