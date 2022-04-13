<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Helper;

use Nette\PhpGenerator\PhpFile;

class UseModel
{
    private string $name;

    private string $type;

    private ?string $alias;

    /**
     * Use model constructor.
     *
     * @param string      $name
     * @param string      $type
     * @param null|string $alias
     *
     * @see PhpFile::addUse()
     */
    public function __construct(
        string $name,
        string $type,
        ?string $alias = null
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->alias = $alias;
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
     * Returns type.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
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
}
