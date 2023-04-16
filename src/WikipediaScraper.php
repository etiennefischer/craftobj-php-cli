<?php

namespace Etienne\Craftobj;

use Exception;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
class WikipediaScraper
{
    private string $input;

    public function __construct(string $input)
    {
        $this->input = $input;
    }

    public function scrape(): array
    {
        $client = new Client();
        $crawler = $client->request('GET', 'https://fr.wikipedia.org/wiki/' . $this->input);

        //verify if a table with the class "infobox_v2" exists
        $crawler->filter('.infobox_v2')->each(function (Crawler $node) {
            if ($node->count() === 0) {
                throw new Exception('Tableau introuvable');
            }
        });
        //get the table
        $table = $crawler->filter('.infobox_v2')->first();
        //get all the th elements and their text
        $th = $table->filter('th')->each(function (Crawler $node) {
            return $node->text();
        });

        var_dump($th);
        //get all the td associated with the th and their text
        $td = $table->filter('th')->each(function (Crawler $node) {
           $values = $node->siblings()->text();
           return $this->parseAttributes($values);
        });

        var_dump($td);

        if (empty($th) || empty($td)) {
            throw new Exception('Tableau incomplet');
        }

        return array_combine($th, $td);

    }

    private function parseAttributes(string $attributeValue): mixed
    {
        $attributeValue = str_replace(' et', ',', $attributeValue);
        if (strpos($attributeValue, ',') !== false) {
            return array_map('trim', explode(',', $attributeValue));
        }

        return $attributeValue;
    }

}