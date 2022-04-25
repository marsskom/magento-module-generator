<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Context;

use Marsskom\Generator\Api\Data\CloneableInterface;
use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Api\Data\Template\TemplateInterface;

class Context implements ContextInterface, CloneableInterface
{
    private TemplateInterface $template;

    private string $path;

    private string $fileName;

    /**
     * Context constructor.
     *
     * @param TemplateInterface $template
     * @param string            $path
     * @param string            $fileName
     */
    public function __construct(
        TemplateInterface $template,
        string $path = '',
        string $fileName = ''
    ) {
        $this->template = $template;
        $this->path = $path;
        $this->fileName = $fileName;
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
    public function __clone()
    {
        $this->template = clone $this->template;
    }
}
