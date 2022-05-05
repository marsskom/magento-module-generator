<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Domain\Mock\Observer;

use Marsskom\Generator\Domain\Exception\Observer\EventNameNotExistsException;
use Marsskom\Generator\Domain\Interfaces\Observer\ObserverInterface;
use Marsskom\Generator\Domain\Interfaces\Observer\SubjectInterface;
use Marsskom\Generator\Domain\Interfaces\ValueObjectInterface;

class InArrayComplexObserver extends IntArraySubject implements ObserverInterface
{
    /**
     * @inheritdoc
     *
     * @throws EventNameNotExistsException
     */
    public function receive(SubjectInterface $subject, string $eventName, ValueObjectInterface $payload): void
    {
        /** @var IntArraySubject $subject */
        $this->trigger($eventName, $payload);

        foreach ($this->get() as $integer) {
            $subject->add($integer);
        }

        $this->clean();
    }
}
