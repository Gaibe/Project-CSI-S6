<?php

class Hydrator {


    public static function hydrate($array_to_hydrate, $obj) {
        if ($array_to_hydrate != null) {
            foreach ($array_to_hydrate as $key => $result) {
                $obj->__set($key, $result);
            }
            return $obj;
        }
        else {
            return -1;
        }
    }
}