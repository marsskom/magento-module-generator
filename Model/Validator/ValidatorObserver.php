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

    /**
     * Observer constructor.
     *
     * @param string               $eventName
     * @param ValidatorInterface[] $attachValidators
     */
    public function __construct(
        string $eventName = '',
        array $attachValidators = []
    ) {
        foreach ($attachValidators as $class) {
            $this->attach($eventName, $class);
        }
    }

    /**
     * @inheritdoc
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
     * @inheritdoc
     */
    public function notify(string $eventName, array $userInput): ValidateResultInterface
    {
        $concreteValidator = $this->observers[$eventName] ?? null;

        if (null === $concreteValidator) {
            return (new ValidatorResultBuilder())->createPassed();
        }

        return $concreteValidator->validate($userInput);
    }
}
