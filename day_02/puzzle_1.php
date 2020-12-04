<?php

// Read file, content in $list array
$file = fopen("input.txt", "r") or die("Error while opening file");
while(!feof($file)){
    $list[] = fgets($file);
}
fclose($file);


$valid_counter = 0;
foreach ($list as $line){
    list($min_max, $target_char_dirty, $password) = explode(" ", $line);
    list($min, $max) = explode("-", $min_max);
    $target_char = $target_char_dirty[0];

    $total_occurrences = 0;
    foreach (str_split($password) as $char)
             // "==" returns 1 if they're equal, 0 if they're different
            $total_occurrences += ( $char == $target_char );

    if( ($total_occurrences >= $min) && ($total_occurrences <= $max) ){
        $valid_counter++;
    }
}

echo "Total correct passwords: " . $valid_counter;