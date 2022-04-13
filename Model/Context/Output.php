<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Context;

use Marsskom\Generator\Api\Data\Context\OutputInterface;

class Output implements OutputInterface
{
    /**
     * @var mixed
     */
    private $state = null;

    /**
     * @inheritdoc
     */
    public function setState($value): OutputInterface
    {
        $this->state = $value;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @inheritdoc
     */
    public function asString(): string
    {
        return (string) $this->state;
    }
}
