<?php

// Read file, content in $list array
$file = fopen("input.txt", "r") or die("Error while opening file");
while(!feof($file)){
    $list[] = fgets($file);
}
fclose($file);


$valid_counter = 0;
foreach ($list as $line){
    list($indexes, $target_char_dirty, $password) = explode(" ", $line);
    list($first, $second) = explode("-", $indexes);
    $target_char = $target_char_dirty[0];

    // Check if the password doesn't contain the selected indexes
    if(strlen($password) > max($first, $second)){
        $first_match = ( $target_char == $password[$first - 1] );
        $second_match = ( $target_char == $password[$second - 1] );

        if($first_match != $second_match){
            $valid_counter++;
        }
    }

}

echo "Total correct passwords: " . $valid_counter;