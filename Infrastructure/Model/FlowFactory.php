<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Infrastructure\Model;

use Marsskom\Generator\Domain\Interfaces\Callables\CallableBuilderInterfaceFactory;
use Marsskom\Generator\Domain\Interfaces\FlowInterface;
use Marsskom\Generator\Domain\Interfaces\FlowInterfaceFactory;
use Marsskom\Generator\Domain\Scope\CallableWrapper;
use Marsskom\Generator\Domain\Scope\ScopeFactory;
use Marsskom\Generator\Domain\Scope\Wrapper\Observer\ParameterObserver;
use Marsskom\Generator\Domain\Scope\Wrapper\Observer\ScopeObserver;
use Marsskom\Generator\Infrastructure\Api\Data\FlowFactoryInterface;

class FlowFactory implements FlowFactoryInterface
{
    private CallableBuilderInterfaceFactory $builderFactory;

    private FlowInterfaceFactory $flowFactory;

    /**
     * Flow factory constructor.
     *
     * @param CallableBuilderInterfaceFactory $builderFactory
     * @param FlowInterfaceFactory            $flowFactory
     */
    public function __construct(
        CallableBuilderInterfaceFactory $builderFactory,
        FlowInterfaceFactory $flowFactory
    ) {
        $this->builderFactory = $builderFactory;
        $this->flowFactory = $flowFactory;
    }

    /**
     * @inheritdoc
     */
    public function create(): FlowInterface
    {
        $builder = $this->builderFactory
            ->create()
            ->withObserver(CallableWrapper::FORM_PARAMETER_EVENT, new ParameterObserver())
            ->withObserver(
                CallableWrapper::PREPARE_SCOPE_EVENT,
                new ScopeObserver(new ScopeFactory())
            );

        return $this->flowFactory->create(['builder' => $builder]);
    }
}
