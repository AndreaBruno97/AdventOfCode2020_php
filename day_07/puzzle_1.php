<?php
function enforceRules($rules, &$colors, $current, &$counter){
    if(array_key_exists($current, $rules) == false){
        //  This bag can't be contained by any other bag
        return;
    }

    foreach ($rules[$current] as $next){
        // Search for all the bags that can contain the current one
        if($colors[$next] == 1){
            // This bag was already marked
            continue;
        }

        $colors[$next] = 1;
        $counter++;
        enforceRules($rules, $colors, $next, $counter);
    }
    return;
}

// Read file, content in $list array
$file = fopen("input.txt", "r") or die("Error while opening file");
while(!feof($file)){
    $list[] = fgets($file);
}
fclose($file);

/*
Initialization of the dictionaries:
rules
        key is the inner bag
        value is the set of bags that can contain it
colors
        key is the color
        value is 0 (later set to 1 if it can contain the target)
*/

$rules = [];
$colors = [];

foreach($list as $line_dirty){
    // Delete final space
    $line = str_replace(".", "", $line_dirty);
    $line = str_replace("\r\n", "", $line);

    list($outer, $inner_dirty) = explode(" bags contain ", $line);

    $colors[$outer] = 0;

    if($inner_dirty == "no other bags"){
        continue;
    }
    $inner_dirty =  preg_replace("( bag(s)?)", "", $inner_dirty);
    $inner_list = explode(", ", $inner_dirty);

    foreach ($inner_list as $inner) {
        list($inner_num, $inner_name) = explode(" ", $inner, 2);

        if(array_key_exists($inner_name, $rules) == false){
            $rules[$inner_name] = [];
        }
        $rules[$inner_name][] = $outer;
    }
}

$target = "shiny gold";
$counter = 0;
enforceRules($rules, $colors, $target, $counter);

echo "There are " . ($counter) . " possible colors";


