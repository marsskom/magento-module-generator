<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Validator;

use Marsskom\Generator\Api\Data\Validator\ValidateResultInterface;
use Marsskom\Generator\Api\Data\Validator\ValidatorInterface;
use Marsskom\Generator\Exception\ValidateException;

abstract class Validator implements ValidatorInterface
{
    protected ?ValidatorInterface $next = null;

    /**
     * Validator constructor.
     *
     * @param null|ValidatorInterface $next
     */
    public function __construct(
        ?ValidatorInterface $next = null
    ) {
        $this->next = $next;
    }

    /**
     * @inheritdoc
     */
    public function setNext(ValidatorInterface $validator): ValidatorInterface
    {
        $this->next = $validator;

        return $validator;
    }

    /**
     * @inheritdoc
     */
    public function getNext(): ?ValidatorInterface
    {
        return $this->next;
    }

    /**
     * @inheritdoc
     */
    public function validate(array $userInput): ValidateResultInterface
    {
        try {
            $this->concreteValidate($userInput);
        } catch (ValidateException $exception) {
            return (new ValidatorResultBuilder())->createFailed(
                $exception->getMessage(),
                $exception->getTrace()
            );
        }

        if (null !== $this->next) {
            return $this->next->validate($userInput);
        }

        return (new ValidatorResultBuilder())->createPassed();
    }

    /**
     * Concrete validation method.
     *
     * @param array $userInput
     *
     * @throws ValidateException
     */
    abstract protected function concreteValidate(array $userInput): void;
}
