<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Stub;

use Marsskom\Generator\Api\Data\StubInterface;

class File implements StubInterface
{
    private string $namespace;

    private string $annotation;

    private array $uses;

    /**
     * File constructor.
     *
     * @param string $namespace
     * @param string $annotation
     * @param array  $uses
     */
    public function __construct(
        string $namespace,
        string $annotation = '',
        array $uses = []
    ) {
        $this->namespace = $namespace;
        $this->annotation = $annotation;
        $this->uses = $uses;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [
            'namespace'  => $this->namespace,
            'annotation' => $this->annotation,
            'uses'       => $this->uses,
        ];
    }

    /**
     * @inheritdoc
     */
    public function getKey(): string
    {
        return 'file';
    }
}
