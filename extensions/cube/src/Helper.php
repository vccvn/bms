<?php

namespace Cube;

class Helper{
    public static function array_parse($main=null,$push=null,$keepIndex=false){
        $main = (array) $main;
        if(is_array($push)){
            foreach($push as $k => $v){
                if(is_numeric($k)) {
                    if($keepIndex){
                        $main[$k] = $v;
                    }
                    else{
                        $main[] = $v;
                    }
                }
                elseif(!isset($main[$k])||!$main[$k]) $main[$k] = $v;
            }
        }
        return $main;
    }
    public static function to_array($d) {
        if (is_object($d)) {
            $d = get_object_vars($d);
        }
    
        if (is_array($d)) {
            return array_map(__METHOD__, $d);
        }
        else {
            return $d;
        }
    }
}