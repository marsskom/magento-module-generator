<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Domain\Mock\Observer;

use Marsskom\Generator\Domain\Interfaces\Observer\ObserverInterface;
use Marsskom\Generator\Domain\Interfaces\Observer\SubjectInterface;
use Marsskom\Generator\Domain\Interfaces\ValueObjectInterface;

class IntArrayObserver implements ObserverInterface
{
    /**
     * @inheritdoc
     */
    public function receive(SubjectInterface $subject, string $eventName, ValueObjectInterface $payload): void
    {
        /** @var IntArraySubject $subject */
        $subject->add($payload->value());
    }
}
