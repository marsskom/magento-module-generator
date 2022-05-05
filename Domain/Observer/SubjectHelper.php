<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Observer;

use Marsskom\Generator\Domain\Interfaces\Observer\ObserverInterface;
use Marsskom\Generator\Domain\Interfaces\Observer\SubjectInterface;

trait SubjectHelper
{
    /**
     * @var array<string, ObserverInterface[]>
     */
    private array $observers = [];

    /**
     * Adds observer.
     *
     * @param string            $eventName
     * @param ObserverInterface $observer
     *
     * @return object
     */
    public function withObserver(string $eventName, ObserverInterface $observer): object
    {
        $this->observers[$eventName][] = $observer;

        return $this;
    }

    /**
     * Attaches observers to subject.
     *
     * @param SubjectInterface|object $subject
     *
     * @return mixed
     */
    public function attachTo(SubjectInterface $subject)
    {
        foreach ($this->observers as $eventName => $observers) {
            foreach ($observers as $observer) {
                $subject = $subject->attach($eventName, $observer);
            }
        }

        return $subject;
    }
}
