<?php

namespace Etienne\Craftobj;

class ClassGenerator
{
    private string $className;

    public function __construct(string $className)
    {
        $this->className = $className;
    }

    public function generate(array $properties): string
    {
        $class = "<?php \n \n namespace Etienne\Craftobj; \n \n class $this->className \n { \n";
        //properties
        foreach ($properties as $property => $value) {
            $property = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $property))));
            $property = \Transliterator::create('NFD; [:Nonspacing Mark:] Remove; NFC')->transliterate($property);
            $class .= "    private string \${$property}; \n";
        }

        //constructor
        $class .= " \n";
        $class .= "    public function __construct() \n";
        $class .= "    { \n";
        $class .= "    } \n \n";

        //add sample method
        $class .= "    public function sample(): $this->className \n";
        $class .= "    { \n";
        $class .= "        return (new self())\n";

        foreach ($properties as $property => $value) {
           $property = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $property))));
           $property = \Transliterator::create('NFD; [:Nonspacing Mark:] Remove; NFC')->transliterate($property);
           $class .= "            ->set" . ucfirst($property) . "('$value')\n";
        }
        $class .= "        ;\n";
        $class .= "    } \n \n";

        //getters and setters
        foreach ($properties as $property => $value) {
            $property = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $property))));
            $property = \Transliterator::create('NFD; [:Nonspacing Mark:] Remove; NFC')->transliterate($property);

            $class .= "    public function get" . ucfirst($property) . "(): string \n";
            $class .= "    { \n";
            $class .= "        return \$this->{$property};\n";
            $class .= "    } \n \n";

            $class .= "    public function set" . ucfirst($property) . "(string \${$property}): self \n";
            $class .= "    { \n";
            $class .= "        \$this->{$property} = \${$property};\n \n";
            $class .= "        return \$this;\n";
            $class .= "    } \n \n";
        }

        $class .= "} \n";

        return $class;
    }

    public function  write(string $class, string $output): void
    {
        $filepath = $output . '/' . $this->className . '.php';

        if (!is_dir(dirname($filepath))) {
            mkdir(dirname($filepath), 0777, true);
        }

        file_put_contents($filepath, $class);
    }
}