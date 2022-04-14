<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Stub;

use Marsskom\Generator\Api\Data\StubInterface;

class ClassStub implements StubInterface
{
    private string $name;

    private string $annotation;

    /**
     * Class stub constructor.
     *
     * @param string $name
     * @param string $annotation
     */
    public function __construct(
        string $name,
        string $annotation = ''
    ) {
        $this->name = $name;
        $this->annotation = $annotation;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [
            'name'       => $this->name,
            'annotation' => $this->annotation,
        ];
    }

    /**
     * @inheritdoc
     */
    public function getKey(): string
    {
        return 'class';
    }
}
