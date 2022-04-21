<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem;

use Closure;
use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Foundation\AbstractSequence;

class FileNameChanger extends AbstractSequence
{
    private string $prefix;

    private string $suffix;

    private string $extension;

    private ?Closure $callback;

    /**
     * @inheritdoc
     *
     * @param string        $prefix
     * @param string        $suffix
     * @param string        $extension
     * @param null|callable $callback
     */
    public function __construct(
        string $prefix = '',
        string $suffix = '',
        string $extension = 'php',
        ?Closure $callback = null,
        array $sequences = []
    ) {
        parent::__construct($sequences);

        $this->prefix = $prefix;
        $this->suffix = $suffix;
        $this->extension = $extension;
        $this->callback = $callback ??
            static function (ContextInterface $context) {
                return $context->getUserInput()[InputParameter::NAME] ?? '';
            };
    }

    /**
     * @inheritdoc
     */
    public function execute(ContextInterface $context): ContextInterface
    {
        return $context->setFileName($this->getFileName($context));
    }

    /**
     * Returns changed name.
     *
     * @param ContextInterface $context
     *
     * @return string
     */
    protected function getFileName(ContextInterface $context): string
    {
        return $this->prefix . ($this->callback)($context) . $this->suffix . '.' . $this->extension;
    }
}
