<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Infrastructure\Model\TemplateEngine\Mustache;

use Marsskom\Generator\Domain\Interfaces\Observer\ObserverInterface;
use Marsskom\Generator\Domain\Interfaces\Observer\SubjectInterface;
use Marsskom\Generator\Domain\Interfaces\ValueObjectInterface;
use Marsskom\Generator\Magento\Model\Enum\TemplateVariable;

class ParamObserver implements ObserverInterface
{
    /**
     * @inheritdoc
     */
    public function receive(SubjectInterface $subject, string $eventName, ValueObjectInterface $payload): void
    {
        /** @var $subject Param */

        $variables = $payload->value();

        if (!empty($variables[TemplateVariable::CLASS_EXTENDS])) {
            $variables[TemplateVariable::CLASS_EXTENDS] = $this->implodeExtends(
                $variables[TemplateVariable::CLASS_EXTENDS]
            );
        }
        if (!empty($variables[TemplateVariable::CLASS_IMPLEMENTS])) {
            $variables[TemplateVariable::CLASS_IMPLEMENTS] = $this->implodeImplements(
                $variables[TemplateVariable::CLASS_IMPLEMENTS]
            );
        }

        $subject->setVariables($variables);
    }

    /**
     * Returns extends string.
     *
     * @param null|array $values
     *
     * @return string
     */
    protected function implodeExtends(?array $values): string
    {
        return $values ? ' extends ' . implode(', ', $values) : '';
    }

    /**
     * Returns implements string.
     *
     * @param null|array $values
     *
     * @return string
     */
    protected function implodeImplements(?array $values): string
    {
        return $values ? ' implements ' . implode(', ', $values) : '';
    }
}
