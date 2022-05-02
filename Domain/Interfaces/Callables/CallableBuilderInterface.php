<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Interfaces\Callables;

use Marsskom\Generator\Domain\Exception\Callables\IsNotCallableException;
use Marsskom\Generator\Domain\Interfaces\Observer\ObserverInterface;

interface CallableBuilderInterface
{
    /**
     * Adds observer.
     *
     * @param string            $eventName
     * @param ObserverInterface $observer
     *
     * @return object
     */
    public function withObserver(string $eventName, ObserverInterface $observer): object;

    /**
     * Builds callbacks pipelines.
     *
     * @param array $callables
     *
     * @return array
     *
     * @throws IsNotCallableException
     */
    public function build(array $callables): array;
}
