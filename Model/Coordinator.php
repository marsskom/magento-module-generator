<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model;

use Magento\Framework\Exception\FileSystemException;
use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Api\Data\CoordinatorInterface;
use Marsskom\Generator\Api\Data\Translator\TranslatorInterface;
use Marsskom\Generator\Model\Context\Builder\ContextBuilder;

class Coordinator implements CoordinatorInterface
{
    private ContextBuilder $contextBuilder;

    private TranslatorInterface $translator;

    /**
     * @var array<string, string>
     */
    private array $input;

    /**
     * Coordinator constructor.
     *
     * @param ContextBuilder        $contextBuilder
     * @param TranslatorInterface   $translator
     * @param array<string, string> $input
     */
    public function __construct(
        ContextBuilder $contextBuilder,
        TranslatorInterface $translator,
        array $input
    ) {
        $this->contextBuilder = $contextBuilder;
        $this->translator = $translator;
        $this->input = $input;
    }

    /**
     * @inheritdoc
     */
    public function setInput(array $input): CoordinatorInterface
    {
        $this->input = $input;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setTranslator(TranslatorInterface $translator): CoordinatorInterface
    {
        $this->translator = $translator;

        return $this;
    }

    /**
     * @inheritdoc
     *
     * @throws FileSystemException
     */
    public function getContext(): ContextInterface
    {
        return $this->contextBuilder->create($this->input, $this->translator);
    }
}
