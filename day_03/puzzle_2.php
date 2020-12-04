<?php

// Read file, content in $list array
$file = fopen("input.txt", "r") or die("Error while opening file");
while(!feof($file)){
    $list[] = fgets($file);
}
fclose($file);

// Delete all newline and special characters (all characters that are not "." or "#")
$line_without_newline = preg_replace('/[^.#]/', '', $list[0]);
$module = strlen($line_without_newline) ;

$total_product = 1;
$slope_x_list = [1, 3, 5, 7, 1];
$slope_y_list = [1, 1, 1, 1, 2];

for ($i = 0; $i < count($slope_x_list); $i++){
    // In each cycle it's evaluated a new couple x-y of the slope
    $slope_x = $slope_x_list[$i];
    $slope_y = $slope_y_list[$i];
    $trees = 0;
    $current_x = 0;

    for ($index = 0; $index < count($list); $index++){
        // check if the line has to be skipped, given the current slope_y
        if($index % $slope_y != 0)
            continue;

        // Delete all newline and special characters (all characters that are not "." or "#")
        $line = preg_replace('/[^.#]/', '', $list[$index]);

        $trees += ( $line[$current_x] == "#" );
        /*
        The next point in the next line is given by (old + slope_x) mod N,
        where N is $module, the length of each line
        */
        $current_x = ($current_x + $slope_x) % $module;
    }

    $total_product *= $trees;
}

echo "The product od the trees of each slope is " . $total_product;