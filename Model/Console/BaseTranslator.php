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
    private SplQueue $inputTranslators;

    private array $inputContexts;

    private InputFactory $inputFactory;

    /**
     * Base translator constructor.
     *
     * @param array        $inputTranslators
     * @param array        $inputContexts
     * @param InputFactory $inputFactory
     */
    public function __construct(
        array $inputTranslators,
        array $inputContexts,
        InputFactory $inputFactory
    ) {
        $this->inputTranslators = new SplQueue();
        $this->addInputTranslators($inputTranslators);

        $this->inputContexts = $inputContexts;
        $this->inputFactory = $inputFactory;
    }

    /**
     * @inheritdoc
     */
    public function addInputTranslators(array $inputTranslators): TranslatorInterface
    {
        foreach ($inputTranslators as $translator) {
            $this->inputTranslators->push($translator);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function translate(array $inputOptions): InputInterface
    {
        $options = [];

        foreach ($this->inputTranslators as $translator) {
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
