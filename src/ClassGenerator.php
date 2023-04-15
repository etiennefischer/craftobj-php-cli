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
        $class = "<?php \r \r namespace Etienne\Craftobj; \r \r class $this->className \r { \r";
        //properties
        foreach ($properties as $property => $value) {
            $property = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $property))));
            $property = \Transliterator::create('NFD; [:Nonspacing Mark:] Remove; NFC')->transliterate($property);
            $class .= "    private string \${$property}; \r";
        }

        //constructor
        $class .= " \r";
        $class .= "    public function __construct() \r";
        $class .= "    { \r";
        $class .= "    } \r \r";

        //add sample method
        $class .= "    public function sample(): $this->className \r";
        $class .= "    { \r";
        $class .= "        return (new self())\n";

        foreach ($properties as $property => $value) {
           $property = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $property))));
           $property = \Transliterator::create('NFD; [:Nonspacing Mark:] Remove; NFC')->transliterate($property);
           $class .= "            ->set" . ucfirst($property) . "('$value')\n";
        }
        $class .= "        ;\n";
        $class .= "    } \r \r";

        //getters and setters
        foreach ($properties as $property => $value) {
            $property = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $property))));
            $property = \Transliterator::create('NFD; [:Nonspacing Mark:] Remove; NFC')->transliterate($property);

            $class .= "    public function get" . ucfirst($property) . "(): string \r";
            $class .= "    { \r";
            $class .= "        return \$this->{$property};\n";
            $class .= "    } \r \r";

            $class .= "    public function set" . ucfirst($property) . "(string \${$property}): self \r";
            $class .= "    { \r";
            $class .= "        \$this->{$property} = \${$property};\n \r";
            $class .= "        return \$this;\n";
            $class .= "    } \r \r";
        }

        $class .= "} \r";

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