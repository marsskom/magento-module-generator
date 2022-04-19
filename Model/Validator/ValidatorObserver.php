<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Validator;

use Marsskom\Generator\Api\Data\Validator\ValidateResultInterface;
use Marsskom\Generator\Api\Data\Validator\ValidationObserverInterface;
use Marsskom\Generator\Api\Data\Validator\ValidatorInterface;

class ValidatorObserver implements ValidationObserverInterface
{
    /**
     * @var array<string, ValidatorInterface>
     */
    private array $observers = [];

    private ValidatorResultBuilder $resultBuilder;

    /**
     * Validator observer constructor.
     *
     * @param ValidatorResultBuilder $resultBuilder
     */
    public function __construct(
        ValidatorResultBuilder $resultBuilder
    ) {
        $this->resultBuilder = $resultBuilder;
    }

    /**
     * @inheritDoc
     */
    public function attach(string $eventName, ValidatorInterface $validator): void
    {
        $concreteValidator = $this->observers[$eventName] ?? null;

        if (null === $concreteValidator) {
            $this->observers[$eventName] = $validator;

            return;
        }

        while (null !== $concreteValidator->getNext()) {
            $concreteValidator = $concreteValidator->getNext();
        }

        $concreteValidator->setNext($validator);
    }

    /**
     * @inheritDoc
     */
    public function notify(string $eventName, array $userInput): ValidateResultInterface
    {
        $concreteValidator = $this->observers[$eventName] ?? null;

        if (null === $concreteValidator) {
            return $this->resultBuilder->createPassed();
        }

        return $concreteValidator->validate($userInput);
    }
}
