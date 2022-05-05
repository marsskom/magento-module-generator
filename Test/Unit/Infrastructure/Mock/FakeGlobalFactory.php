<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Infrastructure\Mock;

use Marsskom\Generator\Infrastructure\Api\DiFactoryInterface;

class FakeGlobalFactory implements DiFactoryInterface
{
    /**
     * @inheritdoc
     */
    public function create(string $instanceName, array $data = []): object
    {
        return new $instanceName($data);
    }
}
