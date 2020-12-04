<?php

// Read file, all in one line
$content = file_get_contents("input.txt");
$content = explode("\r\n\r\n", $content);

$list_with_cid = ["byr", "iyr", "eyr", "hgt", "hcl", "ecl", "pid", "cid"];
$list_without_cid = ["byr", "iyr", "eyr", "hgt", "hcl", "ecl", "pid"];
sort($list_with_cid);
sort($list_without_cid);
$correct_passports = 0;

foreach ($content as $line_dirty){
    // Modify input file in array of passports: each field is only separated by spaces
    $line = str_replace("\r\n", " ", $line_dirty);

    // Array of fields without value
    $fields_and_values = explode(" ", $line);
    $fields = array();
    foreach ($fields_and_values as $e){
        $fields[] =  explode(":", $e)[0];
    }
    sort($fields);
    /*
     check if the list of fields has all the correct elements
     with or without cid, regardless of the order
    */
    if($fields == $list_with_cid || $fields == $list_without_cid){
        $correct_passports++;
    }

}

echo "There are " . $correct_passports . " correct passports";