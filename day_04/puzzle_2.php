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
    /*
    // Dictionary of fields: key is field name, value is the value
    $fields_and_values = explode(" ", $line);
    foreach ($fields_and_values as $e){
        $key = explode(":", $e)[0];
        $value = explode(":", $e)[1];

        $fields[$key] = $value;
    }*/
    // Dictionary of fields: key is field name, value is the value
    $fields_and_values = explode(" ", $line);
    $fields = array();
    $fields_names = array();
    foreach ($fields_and_values as $e){
        $fields_names[] =  explode(":", $e)[0];

        $key = explode(":", $e)[0];
        $value = explode(":", $e)[1];

        $fields[$key] = $value;
    }
    sort($fields_names);
    /*
     check if the list of fields has all the correct elements
     with or without cid, regardless of the order
     if not, pass over it
    */
    if($fields_names != $list_with_cid && $fields_names != $list_without_cid)
        continue;

    $pattern_byr = "/^19[2-9][0-9]|200[0-2]$/";
    if(preg_match($pattern_byr, $fields["byr"]) == 0)
        continue;

    $pattern_iyr = "/^201[0-9]|2020$/";
    if(preg_match($pattern_iyr, $fields["iyr"]) == 0)
        continue;

    $pattern_eyr = "/^202[0-9]|2030$/";
    if(preg_match($pattern_eyr, $fields["eyr"]) == 0)
        continue;

    $pattern_hgt = "/^(1[5-8][0-9]|19[0-3])cm|(59|6[0-9]|7[0-6])in$/";
    if(preg_match($pattern_hgt, $fields["hgt"]) == 0)
        continue;

    $pattern_hcl = "/^#[0-9a-f]{6}$/";
    if(preg_match($pattern_hcl, $fields["hcl"]) == 0)
        continue;

    $pattern_ecl = "/^amb|blu|brn|gry|grn|hzl|oth$/";
    if(preg_match($pattern_ecl, $fields["ecl"]) == 0)
        continue;

    $pattern_pid = "/^[0-9]{9}$/";
    if(preg_match($pattern_pid, $fields["pid"]) == 0)
        continue;

    $correct_passports++;
}

echo "There are " . $correct_passports . " correct passports";
