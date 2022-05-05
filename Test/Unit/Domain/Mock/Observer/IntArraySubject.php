<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Domain\Mock\Observer;

use Marsskom\Generator\Domain\Observer\Subject;

class IntArraySubject extends Subject
{
    /**
     * @var int[]
     */
    private array $integers;

    /**
     * Adds digit to array.
     *
     * @param int $digit
     *
     * @return void
     */
    public function add(int $digit): void
    {
        $this->integers[] = $digit;
    }

    /**
     * Returns integers list.
     *
     * @return int[]
     */
    public function get(): array
    {
        return $this->integers;
    }

    /**
     * Cleans array.
     *
     * @return void
     */
    public function clean(): void
    {
        $this->integers = [];
    }
}
