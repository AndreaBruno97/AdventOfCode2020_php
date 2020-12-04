<?php

// Read file, content in $list array
$file = fopen("input.txt", "r") or die("Error while opening file");
while(!feof($file)){
    $list[] = fgets($file);
}
fclose($file);

$trees = 0;
$current_x = 0;
$slope = 3;
// Delete all newline and special characters (all characters that are not "." or "#")
$line_without_newline = preg_replace('/[^.#]/', '', $list[0]);
$module = strlen($line_without_newline) ;

foreach ($list as $line_dirty){
    // Delete all newline and special characters (all characters that are not "." or "#")
    $line = preg_replace('/[^.#]/', '', $line_dirty);

    $trees += ( $line[$current_x] == "#" );
    /*
    The next point in the next line is given by (old + 3) mod N,
    where N is $module, the length of each line
    */
    $current_x = ($current_x + $slope) % $module;
}

echo "There are " . $trees . " trees in the path";