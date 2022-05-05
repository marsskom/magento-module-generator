<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Interfaces\Observer;

use Marsskom\Generator\Domain\Interfaces\ValueObjectInterface;

interface ObserverInterface
{
    /**
     * Receives the subject and an event payload from subject after the event was triggered.
     *
     * @param SubjectInterface     $subject
     * @param string               $eventName
     * @param ValueObjectInterface $payload
     *
     * @return void
     */
    public function receive(SubjectInterface $subject, string $eventName, ValueObjectInterface $payload): void;
}
