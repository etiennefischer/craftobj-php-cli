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
        $crawler = $client->request('GET', 'https://fr.wikipedia.org/w/index.php?search=' . $this->input . '&title=Sp%C3%A9cial:Recherche&profile=advanced&fulltext=1&ns0=1');

        //first result
        $link = $crawler->filter('ul.mw-search-results')->first()->filter('li')->first()->filter('a')->first()->attr('href');
        if (empty($link)) {
            throw new Exception('Aucun résultat trouvé pour ce terme');
        }

        $crawler = $client->request('GET', 'https://fr.wikipedia.org' . $link);
        //verify if a table with the class "infobox_v2" exists
        $crawler->filter('.infobox_v2')->each(function (Crawler $node) {
            if ($node->count() === 0) {
                throw new Exception('Tableau introuvable');
            }
        });
        //get the table
        $table = $crawler->filter('.infobox_v2')->first();
        //get all the th elements who have a td and have a scope attribute 'row' and the td associated is not empty
        $th = $table->filter('th')->each(function (Crawler $node) {
            if ($node->siblings()->count() > 0 && $node->attr('scope') === 'row' && !empty($node->siblings()->first()->text())) {
                return $node->text();
            }
            return null;
        });


        $properties = array_filter($th);

        var_dump($properties);

        //get all the td associated with the th who have a scope attribute 'row'
        $td = $table->filter('th')->each(function (Crawler $node) {
            if ($node->siblings()->count() > 0 && $node->attr('scope') === 'row') {
                return $this->parseAttributes($node->siblings()->first()->text());
            }
            return null;
        });

        $values = array_filter($td);

        var_dump($values);

        if (empty($properties) || empty($values)) {
            throw new Exception('Tableau incomplet');
        }

        return array_combine($properties, $values);

    }

    private function parseAttributes(string $attributeValue): string|array
    {
        $attributeValue = str_replace(' et', ',', $attributeValue);

        if (preg_match('/\d,\d/', $attributeValue)) {
            return $attributeValue;
        }

        if (str_contains($attributeValue, ',')) {
            return array_map('trim', explode(',', $attributeValue));
        }

        return $attributeValue;
    }

}