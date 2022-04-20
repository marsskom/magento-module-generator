<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model;

use Magento\Framework\ObjectManagerInterface;

class GlobalFactory
{
    private ObjectManagerInterface $objectManager;

    /**
     * Factory constructor.
     *
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(
        ObjectManagerInterface $objectManager
    ) {
        $this->objectManager = $objectManager;
    }

    /**
     * Creates class instance with specified parameters.
     *
     * @param string $instanceName
     * @param array  $data
     *
     * @return object
     */
    public function create(string $instanceName, array $data = []): object
    {
        return $this->objectManager->create($instanceName, $data);
    }
}
