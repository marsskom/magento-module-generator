<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Infrastructure\Model\Writer;

use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Io\File;
use Marsskom\Generator\Domain\Exception\Context\VariableNotExistsException;
use Marsskom\Generator\Domain\Interfaces\Context\ContextInterface;
use Marsskom\Generator\Infrastructure\Model\Enum\ContextVariable;
use Marsskom\Generator\Infrastructure\Model\Helper\XmlWriteHelper;

class XmlWriter extends PhpWriter
{
    private XmlWriteHelper $xmlWriteHelper;

    /**
     * @inheritdoc
     *
     * @param XmlWriteHelper $xmlWriteHelper
     */
    public function __construct(Filesystem $filesystem, File $file, XmlWriteHelper $xmlWriteHelper)
    {
        parent::__construct($filesystem, $file);

        $this->xmlWriteHelper = $xmlWriteHelper;
    }

    /**
     * @inheritdoc
     */
    public function validate(string $fileName): bool
    {
        $pathInfo = $this->pathInfo($fileName);

        return 'xml' === $pathInfo['extension'];
    }

    /**
     * @inheritdoc
     *
     * @throws VariableNotExistsException
     * @throws FileSystemException
     */
    public function append(ContextInterface $context): void
    {
        $fileName = (string) $context->get(ContextVariable::FILENAME_VALUE);

        $xmlString = $this->directory()->readFile($fileName);
        $xmlContent = $this->xmlWriteHelper->extract((string) $context->get(ContextVariable::TEMPLATE_VALUE));
        $documentString = $this->xmlWriteHelper->append($xmlString, $xmlContent);

        $this->write($context->set(ContextVariable::TEMPLATE_VALUE, $documentString));
    }
}
