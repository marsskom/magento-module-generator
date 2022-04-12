<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Helper;

use Nette\PhpGenerator\PhpFile;

class UseModel
{
    private string $name;

    private ?string $alias;

    private ?string $type;

    /**
     * Use model constructor.
     *
     * @param string      $name
     * @param null|string $alias
     * @param null|string $type
     *
     * @see PhpFile::addUse()
     */
    public function __construct(
        string $name,
        ?string $alias = null,
        ?string $type = null
    ) {
        $this->name = $name;
        $this->alias = $alias;
        $this->type = $type;
    }

    /**
     * Returns name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns alias.
     *
     * @return null|string
     */
    public function getAlias(): ?string
    {
        return $this->alias;
    }

    /**
     * Returns type.
     *
     * @return null|string
     */
    public function getType(): ?string
    {
        return $this->type;
    }
}
