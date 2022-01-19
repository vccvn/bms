<?php
namespace Cube;

function dd($obj = null){
    echo '<pre>';
    print_r($obj);
    die;
    echo '</pre>';
}
function array_parse($main=null,$push=null,$keepIndex=false){
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