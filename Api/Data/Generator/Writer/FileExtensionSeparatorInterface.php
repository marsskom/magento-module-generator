<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Generator\Writer;

interface FileExtensionSeparatorInterface
{
    /**
     * Returns valid extensions list that writer could manage.
     *
     * @return string[]
     */
    public function validExtensions(): array;
}
