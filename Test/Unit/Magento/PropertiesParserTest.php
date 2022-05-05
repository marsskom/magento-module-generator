<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Magento;

use Marsskom\Generator\Magento\Exception\PropertyStringIsInvalidException;
use Marsskom\Generator\Magento\Model\Parser\PropertiesParser;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class PropertiesParserTest extends MockeryTestCase
{
    /**
     * Tests simple property.
     *
     * @return void
     *
     * @throws PropertyStringIsInvalidException
     */
    public function testSimpleProperty(): void
    {
        $string = "id:?|int:sgc";
        $properties = (new PropertiesParser())->parse($string);
        $idProperty = $properties[0];

        $this->assertEquals('id', $idProperty->getName());

        $this->assertIsArray($idProperty->getTypes());
        $this->assertContains('?', $idProperty->getTypes());
        $this->assertContains('int', $idProperty->getTypes());

        $this->assertTrue($idProperty->hasGetter());
        $this->assertTrue($idProperty->hasSetter());
        $this->assertTrue($idProperty->useInConstructor());
    }

    /**
     * Tests multiple properties.
     *
     * @return void
     *
     * @throws PropertyStringIsInvalidException
     */
    public function testMultipleProperties(): void
    {
        $string = "key:int:s;value:string:g";
        $properties = (new PropertiesParser())->parse($string);
        $this->assertCount(2, $properties);

        $keyProperty = $properties[0];

        $this->assertEquals('key', $keyProperty->getName());

        $this->assertIsArray($keyProperty->getTypes());
        $this->assertContains('int', $keyProperty->getTypes());
        $this->assertCount(1, $keyProperty->getTypes());

        $this->assertFalse($keyProperty->hasGetter());
        $this->assertTrue($keyProperty->hasSetter());

        $valueProperty = $properties[1];

        $this->assertEquals('value', $valueProperty->getName());

        $this->assertIsArray($valueProperty->getTypes());
        $this->assertContains('string', $valueProperty->getTypes());
        $this->assertCount(1, $valueProperty->getTypes());

        $this->assertTrue($valueProperty->hasGetter());
        $this->assertFalse($valueProperty->hasSetter());
    }

    /**
     * Test exception.
     *
     * @param string $inputString
     *
     * @return void
     *
     * @dataProvider exceptionDataProvided
     */
    public function testException(string $inputString): void
    {
        $this->expectException(PropertyStringIsInvalidException::class);

        (new PropertiesParser())->parse($inputString);
    }

    /**
     * Data provided that generates exception.
     *
     * @return string[][]
     */
    public function exceptionDataProvided(): array
    {
        return [
            ["key"],
            ["key;value"],
            ["key|type"],
            ["key|type:g"],
            ["2name:int:sg"],
            ["name:type :g"],
            ["name:2type :g"],
            ["na%me:t\$ype :g"],
        ];
    }
}
