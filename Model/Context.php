<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model;

use Marsskom\Generator\Api\Data\Context\InputInterface;
use Marsskom\Generator\Api\Data\Context\OutputInterface;
use Marsskom\Generator\Api\Data\ContextInterface;

class Context implements ContextInterface
{
    private InputInterface $input;

    private OutputInterface $output;

    /**
     * Context constructor.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    public function __construct(
        InputInterface $input,
        OutputInterface $output
    ) {
        $this->input = $input;
        $this->output = $output;
    }

    /**
     * @inheritdoc
     */
    public function input(): InputInterface
    {
        return $this->input;
    }

    /**
     * @inheritdoc
     */
    public function output(): OutputInterface
    {
        return $this->output;
    }
}
