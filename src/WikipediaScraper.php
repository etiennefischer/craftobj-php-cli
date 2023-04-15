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
                throw new Exception('No table with the class "infobox_v2" found');
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
            return $node->siblings()->text();
        });

        var_dump($td);

        return array_combine($th, $td);

    }

}