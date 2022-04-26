<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem;

use Closure;
use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Foundation\AbstractSequence;
use function call_user_func;

class FileNameChanger extends AbstractSequence
{
    private string $prefix;

    private string $suffix;

    private string $extension;

    /**
     * Closure for `call_user_func`.
     *
     * @var callable|Closure|mixed
     */
    private $callback;

    /**
     * @inheritdoc
     *
     * @param string              $prefix
     * @param string              $suffix
     * @param string              $extension
     * @param null|mixed|callable $callback
     */
    public function __construct(
        string $prefix = '',
        string $suffix = '',
        string $extension = 'php',
        $callback = null,
        array $sequences = []
    ) {
        parent::__construct($sequences);

        $this->prefix = $prefix;
        $this->suffix = $suffix;
        $this->extension = $extension;
        $this->callback = $callback ??
            static function (ScopeInterface $scope) {
                return $scope->input()->get(InputParameter::NAME) ?? '';
            };
    }

    /**
     * @inheritdoc
     */
    public function execute(ScopeInterface $scope): ScopeInterface
    {
        $scope->context()->setFileName($this->getFileName($scope));

        return $scope;
    }

    /**
     * Returns changed name.
     *
     * @param ScopeInterface $scope
     *
     * @return string
     */
    protected function getFileName(ScopeInterface $scope): string
    {
        return $this->prefix
            // @codingStandardsIgnoreLine
            . call_user_func($this->callback, $scope)
            . $this->suffix
            . '.' . $this->extension;
    }
}
