<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem;

use Magento\Framework\Filesystem\Io\File;
use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Exception\Scope\VariableAlreadySetException;
use Marsskom\Generator\Exception\Scope\VariableNotExistsException;
use Marsskom\Generator\Exception\Scope\VariableTypeException;
use Marsskom\Generator\Model\Enum\TemplateVariable;
use Marsskom\Generator\Model\Foundation\AbstractSequence;

class ClassNameFromPathGenerator extends AbstractSequence
{
    private File $file;

    /**
     * @param File  $file
     * @param array $sequences
     */
    public function __construct(
        File $file,
        array $sequences = []
    ) {
        parent::__construct($sequences);

        $this->file = $file;
    }

    /**
     * @inheritdoc
     *
     * @throws VariableNotExistsException
     * @throws VariableAlreadySetException
     * @throws VariableTypeException
     */
    public function execute(ScopeInterface $scope): ScopeInterface
    {
        $scope->var()->set(
            TemplateVariable::CLASS_NAME,
            $this->getFileNameWithoutExtension($scope->context()->getFileName())
        );

        return $scope;
    }

    /**
     * Returns file name without extension.
     *
     * @param string $fileName
     *
     * @return string
     */
    protected function getFileNameWithoutExtension(string $fileName): string
    {
        $pathInfo = $this->file->getPathInfo($fileName);

        return $pathInfo['filename'] ?? '';
    }
}
