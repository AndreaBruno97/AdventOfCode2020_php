<?php

// Read file, all in one line
$content = file_get_contents("input.txt");
//Split the input into groups, since each one is divided by two newlines
$content = explode("\r\n\r\n", $content);

$total = 0;
foreach ($content as $group){
    // I create a string of answers without spaces or newlines
    $group = str_replace("\r\n", "", $group);

    // An associative array can be emulated with a set
    // that has always the same value for each key
    $set = array();
    foreach (str_split($group) as $char){
        $set[$char] = true;
    }

    $total += count($set);
}

echo "The total count is " . $total;