<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Interfaces\Observer;

use Marsskom\Generator\Domain\Exception\Observer\EventNameNotExistsException;
use Marsskom\Generator\Domain\Interfaces\ValueObjectInterface;

interface SubjectInterface
{
    /**
     * Attaches observer to event.
     *
     * @param string            $eventName
     * @param ObserverInterface $observer
     *
     * @return SubjectInterface
     */
    public function attach(
        string $eventName,
        ObserverInterface $observer
    ): SubjectInterface;

    /**
     * Detaches observer from event.
     *
     * @param string            $eventName
     * @param ObserverInterface $observer
     *
     * @return SubjectInterface
     *
     * @throws EventNameNotExistsException
     */
    public function detach(string $eventName, ObserverInterface $observer): SubjectInterface;

    /**
     * Triggers event with payload.
     *
     * @param string               $eventName
     * @param ValueObjectInterface $payload
     *
     * @return void
     *
     * @throws EventNameNotExistsException
     */
    public function trigger(string $eventName, ValueObjectInterface $payload): void;
}
