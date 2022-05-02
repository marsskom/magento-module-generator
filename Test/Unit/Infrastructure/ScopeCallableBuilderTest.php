<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Infrastructure;

use Marsskom\Generator\Domain\Exception\Callables\IsNotCallableException;
use Marsskom\Generator\Domain\Exception\Context\ContextNotFoundException;
use Marsskom\Generator\Domain\Exception\Context\VariableNotExistsException;
use Marsskom\Generator\Domain\Exception\Pipeline\ConditionFailedException;
use Marsskom\Generator\Domain\Interfaces\Callables\CallableBuilderInterface;
use Marsskom\Generator\Domain\Interfaces\Context\ContextInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\InputInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\ScopeInterface;
use Marsskom\Generator\Domain\Pipeline\Pipeline;
use Marsskom\Generator\Domain\Scope\CallableWrapper;
use Marsskom\Generator\Domain\Scope\Context\ContextId;
use Marsskom\Generator\Domain\Scope\Input;
use Marsskom\Generator\Domain\Scope\Observer\ParameterObserver;
use Marsskom\Generator\Domain\Scope\Observer\ScopeObserver;
use Marsskom\Generator\Domain\Scope\Scope;
use Marsskom\Generator\Infrastructure\Model\Context\ArrayRepository;
use Marsskom\Generator\Infrastructure\Model\ScopeCallableBuilder;
use Marsskom\Generator\Test\Unit\Infrastructure\Mock\FakeGlobalFactory;
use Marsskom\Generator\Test\Unit\Infrastructure\Mock\ValueCallable;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use function is_array;

class ScopeCallableBuilderTest extends MockeryTestCase
{
    private CallableBuilderInterface $builder;

    /**
     * @inheritdoc
     */
    protected function mockeryTestSetUp()
    {
        $this->builder = (new ScopeCallableBuilder(new FakeGlobalFactory()))
            ->withObserver(CallableWrapper::FORM_PARAMETER_EVENT, new ParameterObserver())
            ->withObserver(CallableWrapper::PREPARE_SCOPE_EVENT, new ScopeObserver());
    }

    /**
     * @inheritdoc
     */
    protected function mockeryTestTearDown()
    {
        unset($this->builder);
    }

    /**
     * Tests one depth pipeline.
     *
     * @return void
     *
     * @throws IsNotCallableException
     */
    public function testOneDepthPipeline(): void
    {
        $fnResults = [
            'first result',
            'second result',
            'third result',
            'fourth result',
            [ValueCallable::class, ['value' => 'fifth result']],
        ];

        $fns = [];
        foreach ($fnResults as $result) {
            $fns[] = static fn() => $result;
        }

        foreach ($this->builder->build($fns) as $key => $fn) {
            $this->assertEquals(
                $fnResults[$key],
                $fn()
            );
        }
    }

    /**
     * Tests one depth pipeline.
     *
     * @return void
     *
     * @throws IsNotCallableException
     */
    public function testTwoDepthPipeline(): void
    {
        $fns = [
            static fn() => 1,
            [
                [ValueCallable::class, ['value' => 5]],
                static fn() => 2,
                // Here I use prev result because pipeline work with scope and
                // wrapper works with arrays.
                static fn($prev) => $prev . '4',
                static fn($prev) => $prev . '7',
            ],
            static fn() => 3,
        ];

        $string = '';
        foreach ($this->builder->build($fns) as $fn) {
            $res = $fn();
            $string .= is_array($res) ? implode('', $res) : $res;
        }

        $this->assertEquals(
            '12473',
            $string
        );
    }

    /**
     * Tests scope pipeline.
     *
     * @return void
     *
     * @throws IsNotCallableException
     * @throws ContextNotFoundException
     * @throws VariableNotExistsException
     */
    public function testScopePipeline(): void
    {
        $scope = new Scope(
            new ArrayRepository(),
            new Input([
                'param' => 'value',
            ])
        );

        /**
         * @var $s ScopeInterface
         * @var $c ContextInterface
         * @var $i InputInterface
         */
        $fns = [
            static fn($s) => $s->context('default'),
            static fn($c, $i) => $c->set('param', $i->get('param')),
            static fn($i) => $i->get('param'),
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
            static fn($s) => $s->context('context'),
            static fn($c) => $c->set('variable', 'var'),
            static fn($s) => $s->use('default')->set('param2', 'value2'),
        ];

        $pipeline = new Pipeline($this->builder->build($fns));
        $scope = $pipeline($scope)[0];

        $this->assertTrue($scope->repository()->has(new ContextId('default')));
        $this->assertTrue($scope->repository()->has(new ContextId('context')));

        $default = $scope->repository()->get(new ContextId('default'));

        $this->assertTrue($default->has('param'));
        $this->assertEquals('value', $default->get('param'));

        $this->assertTrue($default->has('param2'));
        $this->assertEquals('value2', $default->get('param2'));

        $this->assertFalse($default->has('condition'));
        $this->assertFalse($default->has('condition2'));
        $this->assertFalse($default->has('condition3'));

        $context = $scope->repository()->get(new ContextId('context'));

        $this->assertTrue($context->has('variable'));
        $this->assertEquals('var', $context->get('variable'));
    }
}
