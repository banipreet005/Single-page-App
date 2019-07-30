<?php

namespace App\Http;
use JMS\Serializer\SerializerBuilder;

abstract class JMS
{
    public static function serialize($data){
        $jsonContent = SerializerBuilder::create()->build()->serialize($data, 'json');
        return $jsonContent;
    }
}
