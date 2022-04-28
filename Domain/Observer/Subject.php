<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Observer;

use Marsskom\Generator\Domain\Exception\Observer\EventNameNotExistsException;
use Marsskom\Generator\Domain\Interfaces\CloneableInterface;
use Marsskom\Generator\Domain\Interfaces\Observer\ObserverInterface;
use Marsskom\Generator\Domain\Interfaces\Observer\SubjectInterface;
use Marsskom\Generator\Domain\Interfaces\ValueObjectInterface;
use function sprintf;

class Subject implements SubjectInterface, CloneableInterface
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
        $new = clone $this;
        $new->observers[$eventName][] = $observer;

        return $new;
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

        $new = clone $this;
        foreach ($this->observers[$eventName] as $key => $specific) {
            if ($specific === $observer) {
                unset($new->observers[$eventName][$key]);
            }
        }

        return $new;
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