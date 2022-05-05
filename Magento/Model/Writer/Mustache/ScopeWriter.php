<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Magento\Model\Writer\Mustache;

use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\LocalizedException;
use Marsskom\Generator\Domain\Exception\Context\VariableNotExistsException;
use Marsskom\Generator\Domain\Exception\Observer\EventNameNotExistsException;
use Marsskom\Generator\Domain\Interfaces\Context\ContextInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\ScopeInterface;
use Marsskom\Generator\Domain\Observer\Subject;
use Marsskom\Generator\Domain\ValueObject;
use Marsskom\Generator\Infrastructure\Api\Data\TemplateEngineInterfaceFactory;
use Marsskom\Generator\Infrastructure\Api\PathInterface;
use Marsskom\Generator\Infrastructure\Api\WriterInterface;
use Marsskom\Generator\Infrastructure\Exception\Writer\FileWasSkippedException;
use Marsskom\Generator\Infrastructure\Model\Enum\ContextVariable;
use Marsskom\Generator\Infrastructure\Model\TemplateEngine\Mustache\Param;
use Marsskom\Generator\Magento\Model\Enum\TemplateVariable;
use Marsskom\Generator\Magento\Model\Helper\Builder\ModuleBuilder;
use Marsskom\Generator\Magento\Model\InputQuestion\Writer\FileExistsActionQuestion;
use function sprintf;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class ScopeWriter extends Subject
{
    public const OUTPUT_INFO_EVENT = __CLASS__ . '-output_info_event';

    public const OUTPUT_ERROR_EVENT = __CLASS__ . '-output_error_event';

    public const OUTPUT_ASK_EVENT = __CLASS__ . '-output_ask_event';

    private TemplateEngineInterfaceFactory $engineFactory;

    private PathInterface $path;

    /**
     * @var WriterInterface[]
     */
    private array $writers;

    private string $variant = FileExistsActionQuestion::ACTION_OVERWRITE;

    /**
     * Scope writer constructor.
     *
     * @param TemplateEngineInterfaceFactory $engineFactory
     * @param PathInterface                  $path
     * @param WriterInterface[]              $writers
     * @param array                          $observers
     */
    public function __construct(
        TemplateEngineInterfaceFactory $engineFactory,
        PathInterface $path,
        array $writers,
        array $observers = []
    ) {
        $this->engineFactory = $engineFactory;
        $this->path = $path;
        $this->writers = $writers;

        foreach ($observers as $eventName => $eventObservers) {
            foreach ($eventObservers as $observer) {
                $this->attach($eventName, $observer);
            }
        }
    }

    /**
     * Main execute method.
     *
     * @param ScopeInterface $scope
     *
     * @return void
     *
     * @throws VariableNotExistsException
     * @throws FileSystemException
     * @throws EventNameNotExistsException
     * @throws LocalizedException
     */
    public function execute(ScopeInterface $scope): void
    {
        foreach ($scope->repository()->list() as $context) {
            try {
                $context->get(ContextVariable::BOUNDED_VALUE);
            } catch (VariableNotExistsException $exception) {
                continue;
            }

            $context = $this->prepareContext($context);

            foreach ($this->writers as $writer) {
                if (!$writer->validate((string) $context->get(ContextVariable::FILENAME_VALUE))) {
                    continue;
                }

                $this->write($writer, $context);
            }
        }
    }

    /**
     * Prepares context.
     *
     * @param ContextInterface $context
     *
     * @return ContextInterface
     *
     * @throws VariableNotExistsException
     * @throws LocalizedException
     */
    protected function prepareContext(ContextInterface $context): ContextInterface
    {
        /** @var $param Param */
        $param = $context->get(ContextVariable::BOUNDED_VALUE);

        return $context->set(
            ContextVariable::TEMPLATE_VALUE,
            $this->engineFactory->create()->make($param)
        )->set(
            ContextVariable::FILENAME_VALUE,
            $this->path->path(
                (new ModuleBuilder())->fromMagentoModuleName(
                    $context->get(TemplateVariable::MODULE_NAME)
                ),
                (string) $context->get(ContextVariable::FILENAME_VALUE)
            )
        );
    }

    /**
     * Runs writes action.
     *
     * @param WriterInterface  $writer
     * @param ContextInterface $context
     *
     * @return void
     *
     * @throws EventNameNotExistsException
     * @throws FileSystemException
     * @throws VariableNotExistsException
     */
    protected function write(WriterInterface $writer, ContextInterface $context): void
    {
        if (!$writer->directory()->isFile($context->get(ContextVariable::FILENAME_VALUE))) {
            $writer->write($context);

            return;
        }

        $this->triggerAskEvent($context);

        switch ($this->variant) {
            case FileExistsActionQuestion::ACTION_SKIP:
                try {
                    $writer->skip($context);
                } catch (FileWasSkippedException $exception) {
                    $this->trigger(self::OUTPUT_INFO_EVENT, new ValueObject($exception->getMessage()));
                }

                return;
            case FileExistsActionQuestion::ACTION_APPEND:
                try {
                    $writer->append($context);

                    $this->trigger(self::OUTPUT_INFO_EVENT, new ValueObject(
                        sprintf("File '%s' was updated", $context->get(ContextVariable::FILENAME_VALUE))
                    ));
                } catch (LocalizedException $exception) {
                    $this->trigger(self::OUTPUT_ERROR_EVENT, new ValueObject($exception->getMessage()));
                }

                return;
            default:
                $writer->write($context);

                $this->trigger(self::OUTPUT_INFO_EVENT, new ValueObject(
                    sprintf("File '%s' was overridden", $context->get(ContextVariable::FILENAME_VALUE))
                ));

                return;
        }
    }

    /**
     * Triggers ask event.
     *
     * @param ContextInterface $context
     *
     * @return void
     *
     * @throws EventNameNotExistsException
     * @throws VariableNotExistsException
     */
    protected function triggerAskEvent(ContextInterface $context): void
    {
        $this->trigger(self::OUTPUT_ASK_EVENT, new ValueObject(
            new FileExistsActionQuestion(
                __(
                    "File '%1' already exists. Choose the action append, overwrite, skip (default - overwrite): ",
                    $context->get(ContextVariable::FILENAME_VALUE)
                )
            )
        ));
    }

    /**
     * Sets chose variant.
     *
     * @param string $variant
     */
    public function setVariant(string $variant): void
    {
        $this->variant = $variant;
    }
}
