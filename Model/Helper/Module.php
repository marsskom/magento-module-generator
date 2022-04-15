<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Helper;

class Module
{
    private string $vendor;

    private string $name;

    /**
     * Module model constructor
     *
     * @param string $vendor
     * @param string $name
     */
    public function __construct(
        string $vendor,
        string $name
    ) {
        $this->vendor = $vendor;
        $this->name = $name;
    }

    /**
     * Returns vendor name.
     *
     * @return string
     */
    public function getVendor(): string
    {
        return $this->vendor;
    }

    /**
     * Returns module name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
