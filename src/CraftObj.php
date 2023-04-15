<?php

namespace Etienne\Craftobj;

class CraftObj
{
    private string $className;
    private string $input;
    private string $output;

    public function __construct(string $className, string $input, string $output)
    {
        $this->className = $className;
        $this->input = $input;
        $this->output = $output;
    }

    public function generate(): void
    {
        $scraper = new WikipediaScraper($this->input);
        $properties = $scraper->scrape();

        $generator = new ClassGenerator($this->className);
        $class = $generator->generate($properties);
        $generator->write($class, $this->output);
    }

}