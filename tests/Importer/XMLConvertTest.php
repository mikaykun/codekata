<?php

declare(strict_types=1);

namespace App\Tests\Importer;

use App\Importer\XmlToHtml;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class XMLConvertTest extends TestCase
{
    public static function refToHtmlProvider(): array
    {
        return [
            [
                '<Ref bOwnWindow="false" strAddress="(02389) 123456" strProtocol="tel:" strQuickInfo="Werner">(02389) 123456</Ref>',
                '<a href="tel:(02389) 123456" title="Werner">(02389) 123456</a>'
            ],
            [
                '<Ref bOwnWindow="true" strAddress="(02389) 123456" strProtocol="tel:" strQuickInfo="">(02389) 123456</Ref>',
                '<a target="_blank" href="tel:(02389) 123456">(02389) 123456</a>'
            ],
            [
                '<Ref bOwnWindow="false" strAddress="(02389) 123456" strProtocol="tel:" strQuickInfo="">(02389) 123456</Ref>',
                '<a href="tel:(02389) 123456">(02389) 123456</a>'
            ]
        ];
    }

    #[DataProvider('refToHtmlProvider')]
    public function testConvertRefToHtml(string $inputXML, string $expectedHtml): void
    {
        $resultHtml = XmlToHtml::convertRef($inputXML);
        $this->assertEquals($expectedHtml, $resultHtml);
    }

    public function testConvertCompleteXML(): void
    {
        $inputXML = <<<XML
<p xml:space="preserve">In der kommenden Woche folgen weitere Eucharistiefeiern: Am Montag, 15. Februar, findet die heilige Messe um 18 Uhr mit Vesper, am Dienstag um 7 Uhr mit Laudes, am Aschermittwoch jeweils um 7 und 18 Uhr mit Austeilung des Aschenkreuzes, am Donnerstag um 7 Uhr mit Laudes, am Freitag um 18 Uhr mit Vesper und am Samstag, 20. Februar, wieder um 7 Uhr mit Laudes statt. Für die Sonntags-Gottesdienste und Aschermittwoch wird um Anmeldung per Telefon unter Tel. <Ref bOwnWindow="true" strAddress="(02389) 123456" strProtocol="tel:" strQuickInfo="">(02389) 123456</Ref> oder per E-Mail ( <Ref bOwnWindow="false" strAddress="werne@acmedus.de" strProtocol="mailto:" strQuickInfo="Werner">werne@acmedus.de</Ref> ) gebeten.</p>
XML;
        $resultHtml = XmlToHtml::convert($inputXML);
        $this->assertStringEqualsFile(__DIR__ . '/_support/paragraph.html', $resultHtml);
    }
}
