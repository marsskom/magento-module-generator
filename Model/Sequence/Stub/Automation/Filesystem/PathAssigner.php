<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem;

use Magento\Framework\Exception\FileSystemException;
use Marsskom\Generator\Api\Data\Helper\PathInterface;
use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Foundation\AbstractSequence;

class PathAssigner extends AbstractSequence
{
    private PathInterface $pathHelper;

    private string $path;

    private bool $isAbsolute;

    /**
     * @inheritdoc
     *
     * @param PathInterface $pathHelper
     * @param string        $path
     * @param bool          $isAbsolute - true if path will be calculated from generated module
     *                                  without usage user input into variable `path`
     */
    public function __construct(
        PathInterface $pathHelper,
        string $path = '',
        bool $isAbsolute = false,
        array $sequences = []
    ) {
        parent::__construct($sequences);

        $this->pathHelper = $pathHelper;
        $this->path = $path;
        $this->isAbsolute = $isAbsolute;
    }

    /**
     * @inheritdoc
     *
     * @throws FileSystemException
     */
    public function execute(ScopeInterface $scope): ScopeInterface
    {
        $scope->context()->setPath(
            $this->pathHelper->getPathToFile(
                $scope->input()->get(InputParameter::MODULE),
                $this->getPath($scope)
            )
        );

        return $scope;
    }

    /**
     * Returns generated path.
     *
     * @param ScopeInterface $scope
     *
     * @return string
     */
    protected function getPath(ScopeInterface $scope): string
    {
        if ($this->isAbsolute) {
            return $this->path;
        }

        return $scope->input()->get(InputParameter::PATH)
            . DIRECTORY_SEPARATOR . $this->path;
    }
}
