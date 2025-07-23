<?php

namespace App\Observers;

use Spatie\Crawler\CrawlObservers\CrawlObserver;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class ArticleRepositoryObserver extends CrawlObserver
{
    public array $results = [];

    public ?int $limit = null;

    public function setLimit(?int $limit): void
    {
        $this->limit = $limit;
    }

    public function crawled(
        UriInterface $url,
        ResponseInterface $response,
        ?UriInterface $foundOnUrl = null,
        ?string $linkText = null,
    ): void {
        echo "Crawled: " . $url . PHP_EOL;
        $xml = new \SimpleXMLElement($response->getBody());

        $xml->registerXPathNamespace('oai', 'http://www.openarchives.org/OAI/2.0/');

        $records = $xml->xpath('//oai:record');

        for ($i = 0; $i < ($this->limit ?? count($records)); $i++) { 
            $recordXml = new \SimpleXMLElement($records[0]->asXML());
        
            // Daftarkan namespace ulang di dalam <record>
            $recordXml->registerXPathNamespace('dc', 'http://purl.org/dc/elements/1.1/');
            $recordXml->registerXPathNamespace('oai_dc', 'http://www.openarchives.org/OAI/2.0/oai_dc/');
        
            // Ambil title, creator, identifier, dll.
            $titles = $recordXml->xpath('.//dc:title');
            $creators = $recordXml->xpath('.//dc:creator');
            $description = $recordXml->xpath('.//dc:description');
            $publisher = $recordXml->xpath('.//dc:publisher');
            $date = $recordXml->xpath('.//dc:date');
            $type = $recordXml->xpath('.//dc:type');
            $format = $recordXml->xpath('.//dc:format');
            $identifiers = $recordXml->xpath('.//dc:identifier');
            $source = $recordXml->xpath('.//dc:source');
            $language = $recordXml->xpath('.//dc:language');
            $relation = $recordXml->xpath('.//dc:relation');
        
            $this->results[] = [
                'title' => array_map('strval', $titles),
                'creator' => array_map('strval', $creators),
                'description' => array_map('strval', $description),
                'publisher' => array_map('strval', $publisher),
                'date' => array_map('strval', $date),
                'type' => array_map('strval', $type),
                'format' => array_map('strval', $format),
                'identifier' => array_map('strval', $identifiers),
                'source' => array_map('strval', $source),
                'language' => array_map('strval', $language),
                'relation' => array_map('strval', $relation),
            ];
        }
    }

    public function crawlFailed(
        UriInterface $url,
        RequestException $requestException,
        ?UriInterface $foundOnUrl = null,
        ?string $linkText = null,
    ): void {
        echo "Failed to crawl: " . $url . " - Error: " . $requestException->getMessage() . PHP_EOL;
    }

    public function willCrawl(UriInterface $url, ?string $linkText): void
    {
        parent::willCrawl($url, $linkText);
        echo "Will crawl: " . $url . PHP_EOL;
    }

    public function finishedCrawling(): void
    {
        parent::finishedCrawling();
        echo "Crawl selesai. Jumlah hasil: " . count($this->results) . PHP_EOL;
    }
}
