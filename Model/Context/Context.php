<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Context;

use Marsskom\Generator\Api\Data\Command\InterruptInterface;
use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Api\Data\Template\TemplateInterface;

class Context implements ContextInterface
{
    private TemplateInterface $template;

    private InterruptInterface $interrupt;

    private string $path;

    private string $fileName;

    private array $userInput;

    private array $variables = [];

    /**
     * Context constructor.
     *
     * @param TemplateInterface  $template
     * @param InterruptInterface $interrupt
     * @param string             $path
     * @param string             $fileName
     * @param array              $userInput
     */
    public function __construct(
        TemplateInterface $template,
        InterruptInterface $interrupt,
        string $path = '',
        string $fileName = '',
        array $userInput = []
    ) {
        $this->template = $template;
        $this->interrupt = $interrupt;
        $this->path = $path;
        $this->fileName = $fileName;
        $this->userInput = $userInput;
    }

    /**
     * @inheritdoc
     */
    public function setTemplate(TemplateInterface $template): ContextInterface
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTemplate(): TemplateInterface
    {
        return $this->template;
    }

    /**
     * @inheritdoc
     */
    public function setVariables(array $variables): ContextInterface
    {
        $this->variables = $variables;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getVariables(): array
    {
        return $this->variables;
    }

    /**
     * @inheritdoc
     */
    public function setPath(string $path): ContextInterface
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @inheritdoc
     */
    public function setFileName(string $fileName): ContextInterface
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @inheritdoc
     */
    public function getUserInput(): array
    {
        return $this->userInput;
    }

    /**
     * @inheritdoc
     */
    public function interrupt(): InterruptInterface
    {
        return $this->interrupt;
    }

    /**
     * Clone method.
     *
     * @return void
     */
    public function __clone()
    {
        $this->template = clone $this->template;
        $this->interrupt = clone $this->interrupt;
    }
}
