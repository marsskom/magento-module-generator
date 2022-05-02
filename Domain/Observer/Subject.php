<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Observer;

use Marsskom\Generator\Domain\Exception\Observer\EventNameNotExistsException;
use Marsskom\Generator\Domain\Interfaces\CloneableInterface;
use Marsskom\Generator\Domain\Interfaces\Observer\ObserverInterface;
use Marsskom\Generator\Domain\Interfaces\Observer\SubjectInterface;
use Marsskom\Generator\Domain\Interfaces\ValueObjectInterface;
use function sprintf;

abstract class Subject implements SubjectInterface, CloneableInterface
{
    /**
     * @var array<string, ObserverInterface[]>
     */
    private array $observers = [];

    /**
     * @inheritdoc
     */
    public function attach(string $eventName, ObserverInterface $observer): SubjectInterface
    {
        $this->observers[$eventName][] = $observer;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function detach(string $eventName, ObserverInterface $observer): SubjectInterface
    {
        if (!isset($this->observers[$eventName])) {
            throw new EventNameNotExistsException(
                sprintf("Event '%s' not found", $eventName)
            );
        }

        foreach ($this->observers[$eventName] as $key => $specific) {
            if ($specific === $observer) {
                unset($this->observers[$eventName][$key]);
            }
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function trigger(string $eventName, ValueObjectInterface $payload): void
    {
        if (!isset($this->observers[$eventName])) {
            throw new EventNameNotExistsException(
                sprintf("Event '%s' not found", $eventName)
            );
        }

        foreach ($this->observers[$eventName] as $observer) {
            $observer->receive($this, $eventName, $payload);
        }
    }

    /**
     * @inheritdoc
     */
    public function hasObservers(): bool
    {
        return !empty($this->observers);
    }

    /**
     * @inheritdoc
     */
    public function observers(): array
    {
        return $this->observers;
    }

    /**
     * @inheritdoc
     */
    public function __clone()
    {
        $observers = [];
        foreach ($this->observers as $eventName => $array) {
            foreach ($array as $specific) {
                $observers[$eventName][] = clone $specific;
            }
        }
        $this->observers = $observers;
    }
}
