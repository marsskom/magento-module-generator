<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Console\Command\Patch;

use Marsskom\Generator\Console\Command\GeneratorCommand;
use Marsskom\Generator\Model\Enum\InputParameter;
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
    protected function getDefaultPathParam(): string
    {
        return 'Setup/Patch/Data';
    }

    /**
     * @inheritdoc
     */
    protected function optionsList(): array
    {
        return [
            new InputOption(
                InputParameter::NAME,
                null,
                InputOption::VALUE_REQUIRED,
                'Class name'
            ),
        ];
    }
}
