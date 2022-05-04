<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Infrastructure\Model\Helper;

use DOMDocument;

class XmlWriteHelper
{
    /**
     * Extracts content from xml document.
     *
     * @param string $xmlDocument
     *
     * @return string
     */
    public function extract(string $xmlDocument): string
    {
        if (empty($xmlDocument)) {
            return '';
        }

        $document = new DOMDocument();
        $document->loadXML($xmlDocument);

        $result = [];
        foreach ($document->documentElement->childNodes as $node) {
            $result[] = $document->saveXML($node);
        }

        return implode('', $result);
    }

    /**
     * Appends content into xml document.
     *
     * @param string $xmlDocument
     * @param string $xmlContent
     *
     * @return string
     */
    public function append(string $xmlDocument, string $xmlContent): string
    {
        if (empty($xmlDocument) || empty($xmlContent)) {
            return '';
        }

        $document = new DOMDocument();
        $document->loadXML($xmlDocument);

        $fragment = $document->createDocumentFragment();
        $fragment->appendXML($xmlContent);

        $document->documentElement->appendChild($fragment);

        return $document->saveXML();
    }
}
