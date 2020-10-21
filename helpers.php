<?php
function dd($data)
{
    
    echo "<pre>";
    print_r($data);
    die;
}

/**
 * Function that groups an array of associative arrays by some key.
 * 
 * @param Array $data Array that stores multiple associative arrays.
 * @param String $key Property to sort by.
 */
function unique_multidim_array($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();
   
    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}

function group_assoc($array, $key) {
    $return = array();
    foreach($array as $v) {
        $return[$v[$key]][] = $v;
    }
    return $return;
}