<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Console;

use Marsskom\Generator\Api\Data\Context\InputInterface;
use Marsskom\Generator\Api\Data\Context\InputTranslatorInterface;
use Marsskom\Generator\Api\Data\TranslatorInterface;
use Marsskom\Generator\Model\Context\InputFactory;
use SplQueue;
use function array_merge;

class BaseTranslator implements TranslatorInterface
{
    /**
     * @var SplQueue<InputTranslatorInterface>
     */
    private SplQueue $translators;

    private array $inputContexts;

    private InputFactory $inputFactory;

    /**
     * Base translator constructor.
     *
     * @param array        $translators
     * @param array        $inputContexts
     * @param InputFactory $inputFactory
     */
    public function __construct(
        array $translators,
        array $inputContexts,
        InputFactory $inputFactory
    ) {
        $this->translators = new SplQueue();
        $this->addTranslators($translators);

        $this->inputContexts = $inputContexts;
        $this->inputFactory = $inputFactory;
    }

    /**
     * @inheritdoc
     */
    public function addTranslators(array $translators): TranslatorInterface
    {
        foreach ($translators as $translator) {
            $this->translators->push($translator);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function translate(array $inputOptions): InputInterface
    {
        $options = [];

        foreach ($this->translators as $translator) {
            foreach ($translator->translate($this->inputContexts, $inputOptions) as $key => $values) {
                if (!isset($options[$key])) {
                    $options[$key] = $values;

                    continue;
                }

                // phpcs:ignore Magento2.Performance.ForeachArrayMerge
                $options[$key] = array_merge($options[$key], $values);
            }
        }

        $inputContexts = [];
        foreach ($this->inputContexts as $key => $factory) {
            if (!isset($options[$key])) {
                continue;
            }

            $inputContexts[$key] = $factory->create($options[$key]);
        }

        return $this->inputFactory->create($inputContexts);
    }
}
