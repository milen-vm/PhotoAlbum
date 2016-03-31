<?php
namespace MyMVC\Library;

class ValidationParser
{

    private $object;

    public function __construct($object)
    {
        $this->object = new \ReflectionClass($object);

//         var_dump($this->object->getProperties());

        foreach ($this->object->getProperties() as $property) {

            $propertyDoc = $property->getDocComment();
            if ($propertyDoc) {
//                 var_dump($propertyDoc);
                $docCommponents = [];
                preg_match_all('/(@.*) (.*)$/im', $propertyDoc, $docCommponents);
//                 var_dump($docCommponents);
            }
        }
    }


}