<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Context;

use Marsskom\Generator\Api\Data\Template\TemplateInterface;

interface ContextInterface
{
    /**
     * Sets file name.
     *
     * @param string $fileName
     *
     * @return ContextInterface
     */
    public function setFileName(string $fileName): ContextInterface;

    /**
     * Returns file name with extension.
     *
     * @return string
     */
    public function getFileName(): string;

    /**
     * Sets path.
     *
     * @param string $path
     *
     * @return ContextInterface
     */
    public function setPath(string $path): ContextInterface;

    /**
     * Returns path to file.
     *
     * @return string
     */
    public function getPath(): string;

    /**
     * Sets template.
     *
     * @param TemplateInterface $template
     *
     * @return ContextInterface
     */
    public function setTemplate(TemplateInterface $template): ContextInterface;

    /**
     * Returns template.
     *
     * @return TemplateInterface
     */
    public function getTemplate(): TemplateInterface;

    /**
     * Returns context identity.
     *
     * @return string
     */
    public function getContextID(): string;
}
