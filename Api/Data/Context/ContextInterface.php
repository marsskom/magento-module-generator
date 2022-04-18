<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Context;

use Marsskom\Generator\Api\Data\Command\InterruptInterface;
use Marsskom\Generator\Api\Data\Template\TemplateInterface;

interface ContextInterface
{
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
     * Sets template variables.
     *
     * @param array $variables
     *
     * @return ContextInterface
     */
    public function setVariables(array $variables): ContextInterface;

    /**
     * Returns template variables.
     *
     * @return array
     */
    public function getVariables(): array;

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
     * Returns user input.
     *
     * @return array<string, string>
     */
    public function getUserInput(): array;

    /**
     * Returns interrupt object.
     *
     * @return InterruptInterface
     */
    public function interrupt(): InterruptInterface;
}
