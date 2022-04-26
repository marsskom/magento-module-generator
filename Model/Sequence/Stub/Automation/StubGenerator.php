<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Automation;

use Marsskom\Generator\Api\Data\TemplateEngineInterfaceFactory;
use Marsskom\Generator\Model\Foundation\StubGenerator as AbstractStubGenerator;

class StubGenerator extends AbstractStubGenerator
{
    private string $stubName;

    /**
     * @inheritdoc
     *
     * @param string $stubName
     */
    public function __construct(
        TemplateEngineInterfaceFactory $tplEngineFactory,
        string $stubName,
        array $sequences = []
    ) {
        parent::__construct($tplEngineFactory, $sequences);

        $this->stubName = $stubName;
    }

    /**
     * @inheritDoc
     */
    public function getStubName(): string
    {
        return $this->stubName;
    }
}
