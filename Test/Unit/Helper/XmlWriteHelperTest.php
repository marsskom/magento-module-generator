<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Helper;

use Marsskom\Generator\Model\Helper\Writer\XmlWriteHelper;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use function str_replace;

class XmlWriteHelperTest extends MockeryTestCase
{
    /**
     * Tests extract content from xml.
     *
     * @return void
     */
    public function testExtractContent(): void
    {
        $content = '<preference for="Test\Test\Api\Interface" type="Test\Test\Model\Model"/>
<preference for="Test\Test\Api\Interface" type="Test\Test\Model\Model"/>';

        // @codingStandardsIgnoreLine
        $xml = '<?xml version="1.0" encoding="UTF-8"?><config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:ObjectManager/etc/config.xsd">' . $content . '</config>';

        $helper = new XmlWriteHelper();

        $this->assertEquals(
            $content,
            $helper->extract($xml)
        );
    }

    /**
     * Tests append content to xml.
     *
     * @return void
     */
    public function testAppendTest(): void
    {
        $xml = '<?xml version="1.0"?>
<root><first><primary attribute="value"/></first></root>
';
        $content = '<test><a attribute="test"/></test><test2 attribute="value2"/>';

        $helper = new XmlWriteHelper();

        $this->assertEquals(
            str_replace('</root>', $content . '</root>', $xml),
            $helper->append($xml, $content)
        );
    }
}
