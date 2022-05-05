<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Domain;

use Marsskom\Generator\Domain\Exception\Context\ContextNotFoundException;
use Marsskom\Generator\Domain\Exception\Context\VariableNotExistsException;
use Marsskom\Generator\Domain\Exception\Pipeline\ConditionFailedException;
use Marsskom\Generator\Domain\Exception\Validator\ValidateException;
use Marsskom\Generator\Domain\Flow\Flow;
use Marsskom\Generator\Domain\Interfaces\FlowInterface;
use Marsskom\Generator\Domain\Scope\CallableWrapper;
use Marsskom\Generator\Domain\Scope\Context\ContextId;
use Marsskom\Generator\Domain\Scope\Input;
use Marsskom\Generator\Domain\Scope\Scope;
use Marsskom\Generator\Domain\Scope\ScopeFactory;
use Marsskom\Generator\Domain\Scope\Wrapper\Observer\ParameterObserver;
use Marsskom\Generator\Domain\Scope\Wrapper\Observer\ScopeObserver;
use Marsskom\Generator\Infrastructure\Model\Context\ArrayRepository;
use Marsskom\Generator\Infrastructure\Model\ScopeCallableBuilder;
use Marsskom\Generator\Test\Unit\Infrastructure\Mock\FakeGlobalFactory;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use function sprintf;

class FlowTest extends MockeryTestCase
{
    private FlowInterface $flow;

    /**
     * @inheritdoc
     */
    protected function mockeryTestSetUp()
    {
        $builder = (new ScopeCallableBuilder(new FakeGlobalFactory()))
            ->withObserver(CallableWrapper::FORM_PARAMETER_EVENT, new ParameterObserver())
            ->withObserver(
                CallableWrapper::PREPARE_SCOPE_EVENT,
                new ScopeObserver(new ScopeFactory())
            );

        $this->flow = (new Flow($builder))
            ->validator(
                static function ($i): void {
                    if (!$i->has('param')) {
                        throw new ValidateException(
                            sprintf("Input doesn't have '%s' param", 'param')
                        );
                    }
                }
            )
            ->with('default', [
                static fn($c, $i) => $c->set('param', $i->get('param')),
                [
                    static function () {
                        throw new ConditionFailedException("Failed");
                    },
                    [
                        static fn($c) => $c->set('condition', true),
                        static fn($c) => $c->set('condition2', true),
                        static fn($c) => $c->set('condition3', true),
                    ],
                ],
                static fn($s) => $s->use('second')->set('var', 'value2'),
            ])
            ->with('second', [
                static fn($c, $i) => $c->set('custom', 'custom'),
            ])
            ->with('default', [
                static fn($c) => $c->set('var', 'value'),
            ]);
    }

    /**
     * @inheritdoc
     */
    protected function mockeryTestTearDown()
    {
        unset($this->flow);
    }

    /**
     * Tests validate exception.
     *
     * @return void
     */
    public function testValidateException(): void
    {
        $this->expectException(ValidateException::class);

        $this->flow->run(new Scope(new ArrayRepository(), new Input([])));
    }

    /**
     * Tests flow.
     *
     * @return void
     *
     * @throws ContextNotFoundException
     * @throws VariableNotExistsException
     */
    public function testFlow(): void
    {
        $scope = $this->flow->run(new Scope(
            new ArrayRepository(),
            new Input(['param' => 'param_value'])
        ));

        $this->assertTrue($scope->repository()->has(new ContextId('default')));
        $this->assertTrue($scope->repository()->has(new ContextId('second')));

        $default = $scope->repository()->get(new ContextId('default'));

        $this->assertEquals(
            'param_value',
            $default->get('param')
        );
        $this->assertEquals(
            'value',
            $default->get('var')
        );

        $second = $scope->repository()->get(new ContextId('second'));
        $this->assertEquals(
            'custom',
            $second->get('custom')
        );
        $this->assertEquals(
            'value2',
            $second->get('var')
        );
    }
}
