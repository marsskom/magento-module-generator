<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Validator;

use Marsskom\Generator\Api\Data\Validator\ValidateResultInterface;
use Marsskom\Generator\Api\Data\Validator\ValidatorInterface;
use Marsskom\Generator\Exception\ValidateException;

abstract class Validator implements ValidatorInterface
{
    protected ValidatorResultBuilder $resultBuilder;

    protected ?ValidatorInterface $next = null;

    /**
     * Validator constructor.
     *
     * @param ValidatorResultBuilder  $resultBuilder
     * @param null|ValidatorInterface $next
     */
    public function __construct(
        ValidatorResultBuilder $resultBuilder,
        ?ValidatorInterface $next = null
    ) {
        $this->resultBuilder = $resultBuilder;
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
            return $this->resultBuilder->createFailed(
                $exception->getMessage(),
                $exception->getTrace()
            );
        }

        if (null !== $this->next) {
            return $this->next->validate($userInput);
        }

        return $this->resultBuilder->createPassed();
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
