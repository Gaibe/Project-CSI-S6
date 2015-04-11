<?php

class Hydrator {


    public static function hydrate($array_to_hydrate, $obj) {
        foreach ($array_to_hydrate as $key => $result) {
            $obj->__set($key, $result);
        }
        return $obj;
    }
}