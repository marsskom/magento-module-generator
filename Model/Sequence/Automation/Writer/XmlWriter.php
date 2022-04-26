<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Automation\Writer;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem;
use Marsskom\Generator\Api\Data\Generator\Writer\FileExtensionSeparatorInterface;
use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Model\Foundation\AbstractSequence;
use Marsskom\Generator\Model\Helper\Writer\XmlWriteHelper;
use Marsskom\Generator\Model\InputQuestion\Writer\FileExistsActionQuestion;

class XmlWriter extends AbstractSequence implements FileExtensionSeparatorInterface
{
    private Filesystem $filesystem;

    private XmlWriteHelper $xmlWriteHelper;

    /**
     * @inheritdoc
     *
     * @param Filesystem     $filesystem
     * @param XmlWriteHelper $xmlWriteHelper
     */
    public function __construct(
        Filesystem $filesystem,
        XmlWriteHelper $xmlWriteHelper,
        array $sequences = []
    ) {
        parent::__construct($sequences);

        $this->filesystem = $filesystem;
        $this->xmlWriteHelper = $xmlWriteHelper;
    }

    /**
     * @inheritdoc
     *
     * @throws FileSystemException
     */
    public function execute(ScopeInterface $scope): ScopeInterface
    {
        $directory = $this->filesystem->getDirectoryWrite(DirectoryList::APP);

        $fileName = implode(
            DIRECTORY_SEPARATOR,
            [
                $scope->context()->getPath(),
                $scope->context()->getFileName(),
            ]
        );
        $isFileExists = $directory->isFile($fileName);
        if (!$isFileExists) {
            $this->write($scope, $fileName);

            return $scope;
        }

        $question = new FileExistsActionQuestion(__(
            "File '%1' already exists. Choose the action append, overwrite, skip (default - append): ",
            $fileName
        ));
        $fileAction = $scope
            ->interrupt()
            ->choose($question->getQuestion(), $question->getChoices(), $question->getDefault());

        switch ($fileAction) {
            case FileExistsActionQuestion::ACTION_SKIP:
                return $scope;
            case FileExistsActionQuestion::ACTION_OVERWRITE:
                $this->overwrite($scope, $fileName);
                break;
            default:
                $this->append($scope, $fileName);
                break;
        }

        return $scope;
    }

    /**
     * Writes content into file.
     *
     * @param ScopeInterface $scope
     * @param string         $fileName
     *
     * @return void
     *
     * @throws FileSystemException
     */
    protected function write(ScopeInterface $scope, string $fileName): void
    {
        $directory = $this->filesystem->getDirectoryWrite(DirectoryList::APP);

        $stream = $directory->openFile($fileName);
        $stream->lock();
        $stream->write((string) $scope->context()->getTemplate());
        $stream->unlock();
        $stream->close();
    }

    /**
     * Overwrites file.
     *
     * @param ScopeInterface $scope
     * @param string         $fileName
     *
     * @return void
     *
     * @throws FileSystemException
     */
    protected function overwrite(ScopeInterface $scope, string $fileName): void
    {
        $this->write($scope, $fileName);

        $scope->interrupt()->info(
            __("File '%1' was overwritten", $fileName)
        );
    }

    /**
     * Appends content into existing file.
     *
     * @param ScopeInterface $scope
     * @param string         $fileName
     *
     * @return void
     *
     * @throws FileSystemException
     */
    protected function append(ScopeInterface $scope, string $fileName): void
    {
        $directory = $this->filesystem->getDirectoryWrite(DirectoryList::APP);

        $xmlString = $directory->readFile($fileName);
        $xmlContent = $this->xmlWriteHelper->extract((string) $scope->context()->getTemplate());
        $documentString = $this->xmlWriteHelper->append($xmlString, $xmlContent);

        $stream = $directory->openFile($fileName);
        $stream->lock();
        $stream->write($documentString);
        $stream->unlock();
        $stream->close();

        $scope->interrupt()->info(
            __("File '%1' was updated", $fileName)
        );
    }

    /**
     * @inheritDoc
     */
    public function validExtensions(): array
    {
        return ['xml'];
    }
}
