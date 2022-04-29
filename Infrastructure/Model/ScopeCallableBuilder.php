<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Infrastructure\Model;

use Marsskom\Generator\Domain\Callables\ScopeCallableWrapper;
use Marsskom\Generator\Domain\Exception\Callables\IsNotCallableException;
use Marsskom\Generator\Domain\Interfaces\Callables\CallableBuilderInterface;
use Marsskom\Generator\Domain\Pipeline\ConditionPipeline;
use Marsskom\Generator\Infrastructure\Api\DiFactoryInterface;
use function array_shift;
use function is_array;
use function is_callable;
use function is_string;

class ScopeCallableBuilder implements CallableBuilderInterface
{
    private DiFactoryInterface $factory;

    /**
     * Scope callback builder constructor.
     *
     * @param DiFactoryInterface $factory
     */
    public function __construct(
        DiFactoryInterface $factory
    ) {
        $this->factory = $factory;
    }

    /**
     * @inheritdoc
     */
    public function build(array $callables): array
    {
        $wrapperClassName = $this->wrapperClass();
        $result = [];

        foreach ($callables as $callable) {
            if (is_array($callable)) {
                $currentCallback = null;
                if (!is_callable($callable[0]) && $this->isInvokeArray($callable[0])) {
                    $currentCallback = $this->factory->create($callable[0][0], $callable[0][1] ?? []);
                    array_shift($callable);
                } else {
                    $currentCallback = array_shift($callable);
                }

                $result[] = [
                    new ConditionPipeline(
                        new $wrapperClassName($currentCallback),
                        $this->build($callable)
                    ),
                ];

                continue;
            }

            if (!is_callable($callable)) {
                throw new IsNotCallableException("Item is not a callable.");
            }

            $result[] = [new $wrapperClassName($callable)];
        }

        return array_merge(...$result);
    }

    /**
     * Returns true is array is parameters for factory.
     *
     * @param array $array
     *
     * @return bool
     */
    protected function isInvokeArray(array $array): bool
    {
        return is_string($array[0]) && (!isset($array[1]) || is_array($array[1]));
    }

    /**
     * Returns wrapper class.
     *
     * @return string
     */
    protected function wrapperClass(): string
    {
        return ScopeCallableWrapper::class;
    }
}
