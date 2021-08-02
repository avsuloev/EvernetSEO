<?php

namespace App\Service;

use Symfony\Component\DomCrawler\Crawler;

class KeywordsImportService
{
    public function __construct(private Crawler $crawler)
    {
    }

    public function importXml(string $path) {
        $this->crawler->addXmlContent(file_get_contents($path));
    }

    public function importCsv(string $path) {
    }
}
