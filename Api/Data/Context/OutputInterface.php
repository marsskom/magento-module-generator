<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Context;

use Marsskom\Generator\Api\Data\Template\TemplateInterface;

interface OutputInterface
{
    /**
     * Returns path to file.
     *
     * @return string
     */
    public function getPath(): string;

    /**
     * Returns file name with extension.
     *
     * @return string
     */
    public function getFileName(): string;

    /**
     * Sets template.
     *
     * @param TemplateInterface $template
     *
     * @return OutputInterface
     */
    public function set(TemplateInterface $template): OutputInterface;

    /**
     * Returns template.
     *
     * @return TemplateInterface
     */
    public function get(): TemplateInterface;
}
