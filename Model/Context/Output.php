<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Context;

use Marsskom\Generator\Api\Data\Context\OutputInterface;
use Marsskom\Generator\Api\Data\Template\TemplateInterface;

class Output implements OutputInterface
{
    private string $path;

    private string $fileName;

    private TemplateInterface $template;

    /**
     * Output constructor.
     *
     * @param string            $path
     * @param string            $fileName
     * @param TemplateInterface $template
     */
    public function __construct(
        string $path,
        string $fileName,
        TemplateInterface $template
    ) {
        $this->path = $path;
        $this->fileName = $fileName;
        $this->template = $template;
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
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @inheritdoc
     */
    public function set(TemplateInterface $template): OutputInterface
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function get(): TemplateInterface
    {
        return $this->template;
    }
}
