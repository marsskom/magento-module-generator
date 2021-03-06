<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Infrastructure\Model;

use Marsskom\Generator\Domain\Exception\Callables\IsNotCallableException;
use Marsskom\Generator\Domain\Interfaces\Callables\CallableBuilderInterface;
use Marsskom\Generator\Domain\Interfaces\Callables\CallableInterface;
use Marsskom\Generator\Domain\Observer\SubjectHelper;
use Marsskom\Generator\Domain\Pipeline\ConditionPipeline;
use Marsskom\Generator\Domain\Scope\CallableWrapper;
use Marsskom\Generator\Infrastructure\Api\DiFactoryInterface;
use function array_shift;
use function is_array;
use function is_callable;
use function is_string;

class ScopeCallableBuilder implements CallableBuilderInterface
{
    use SubjectHelper;

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
        $result = [];

        foreach ($callables as $callable) {
            if (is_array($callable)) {
                $currentCallback = null;
                if (!is_callable($callable[0])) {
                    if ($this->isInvokeArray($callable)) {
                        $currentCallback = $this->factory->create($callable[0], $callable[1] ?? []);
                    } elseif ($this->isInvokeArray($callable[0])) {
                        $currentCallback = $this->factory->create($callable[0][0], $callable[0][1] ?? []);
                    }

                    array_shift($callable);
                }

                if (null === $currentCallback) {
                    $currentCallback = array_shift($callable);
                }

                $result[] = [
                    new ConditionPipeline(
                        $this->createWrapper($currentCallback),
                        $this->build($callable)
                    ),
                ];

                continue;
            }

            if (!is_callable($callable)) {
                throw new IsNotCallableException("Item is not a callable.");
            }

            $result[] = [$this->createWrapper($callable)];
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
     * Returns callable's wrapper.
     *
     * @param callable $callable
     *
     * @return CallableInterface
     */
    protected function createWrapper(callable $callable): CallableInterface
    {
        return $this->attachTo(new CallableWrapper($callable));
    }
}
