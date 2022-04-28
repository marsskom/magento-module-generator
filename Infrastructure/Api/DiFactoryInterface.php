<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Infrastructure\Api;

interface DiFactoryInterface
{
    /**
     * Creates class instance with specific parameters.
     *
     * @param string $instanceName
     * @param array  $data
     *
     * @return object
     */
    public function create(string $instanceName, array $data = []): object;
}
