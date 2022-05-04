<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Magento\Model\InputQuestion\Writer;

use Magento\Framework\Phrase;

class FileExistsActionQuestion
{
    public const ACTION_APPEND = 'append';

    public const ACTION_OVERWRITE = 'overwrite';

    public const ACTION_SKIP = 'skip';

    private Phrase $question;

    private array $choices;

    /**
     * Default choice.
     *
     * @var mixed
     */
    private $default;

    /**
     * File exists action question constructor.
     *
     * @param Phrase     $question
     * @param null|array $choices
     * @param mixed      $default
     */
    public function __construct(Phrase $question, array $choices = null, $default = null)
    {
        $this->question = $question;
        $this->choices = $choices ?? [self::ACTION_OVERWRITE, self::ACTION_APPEND, self::ACTION_SKIP];
        $this->default = $default ?? 0;
    }

    /**
     * Returns question.
     *
     * @return Phrase
     */
    public function getQuestion(): Phrase
    {
        return $this->question;
    }

    /**
     * Returns choices.
     *
     * @return array
     */
    public function getChoices(): array
    {
        return $this->choices;
    }

    /**
     * Returns default choice.
     *
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }
}
