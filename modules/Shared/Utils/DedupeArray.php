<?php

namespace TP\Shared\Utils;

class DedupeArray
{

    public static function dedupe_multidimensional_array(array $array, string $key) : array
    {
        $i = 0;
        $filteredArray = array();
        $keyArray = array();

        foreach($array as $val) {
            if (!in_array($val[$key], $keyArray)) {
                $keyArray[$i] = $val[$key];
                $filteredArray[$i] = $val;
            }
            $i++;
        }
        return $filteredArray;
    }

    public static function dedupe_array_of_objets(array $array, string $property) : array
    {
        $i = 0;
        $filteredArray = array();
        $keyArray = array();

        foreach($array as $item) {
            if (!in_array($item->$property, $keyArray)) {
                $keyArray[$i] = $item->$property;
                $filteredArray[$i] = $item;
            }
            $i++;
        }
        return $filteredArray;
    }
}
