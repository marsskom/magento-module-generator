<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Infrastructure\Model\Factories;

use Magento\Framework\ObjectManagerInterface;
use Marsskom\Generator\Domain\Interfaces\DiFactoryInterface;

class GlobalFactory implements DiFactoryInterface
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
     * @inheritdoc
     */
    public function create(string $instanceName, array $data = []): object
    {
        return $this->objectManager->create($instanceName, $data);
    }
}
