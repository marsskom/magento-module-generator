<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Automation\Writer;

use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem\Io\File;
use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Api\Data\Generator\Writer\FileExtensionSeparatorInterface;
use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Model\Foundation\AbstractSequence;
use function array_map;
use function in_array;
use function strtolower;

class BasedOnExtensionWriter extends AbstractSequence
{
    private File $file;

    /**
     * Writer constructor.
     *
     * @param File                              $file
     * @param FileExtensionSeparatorInterface[] $sequences
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __construct(
        File $file,
        array $sequences = []
    ) {
        array_map(
            static function (FileExtensionSeparatorInterface $writer) {
            },
            $sequences
        );

        parent::__construct($sequences);

        $this->file = $file;
    }

    /**
     * @inheritdoc
     *
     * @throws FileSystemException
     */
    public function execute(ScopeInterface $scope): ScopeInterface
    {
        /** @var $child FileExtensionSeparatorInterface */
        foreach ($this->children as $child) {
            if (!$this->validateContextFile($scope->context(), $child->validExtensions())) {
                continue;
            }

            $scope = $child->execute($scope);
        }

        return $scope;
    }

    /**
     * Validates context's file.
     *
     * @param ContextInterface $context
     * @param array            $validExtensions
     *
     * @return bool
     */
    protected function validateContextFile(ContextInterface $context, array $validExtensions): bool
    {
        $pathInfo = $this->file->getPathInfo($context->getFileName());

        return in_array(strtolower($pathInfo['extension']), $validExtensions, true);
    }
}
