<?php
class Color{
    public $name;
    public $num;

    public function __construct($a, $b){
        $this->name = $a;
        $this->num = $b;
    }
}

function enforceRules($rules, &$colors, $current, &$counter): int
{
    $inner_counter = 0;

    if(array_key_exists($current, $rules) == false){
        //  This bag can't contain any other bag
        return 0;
    }

    foreach ($rules[$current] as $next){
        // Search for all the bags that can be contained by the current one

        $colors[$next->name] = 1;
        $counter++;
        $tmp_counter = enforceRules($rules, $colors, $next->name, $counter);
        $inner_counter += ($tmp_counter + 1) * $next->num;
    }
    return $inner_counter;
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
        key is the outer bag
        value is the set of inner bags and their number
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

        if(array_key_exists($outer, $rules) == false){
            $rules[$outer] = [];
        }
        $rules[$outer][] = new Color($inner_name, $inner_num);
    }
}

$target = "shiny gold";
$counter = 0;

$cumulative_counter = enforceRules($rules, $colors, $target, $counter);

echo "There are " . ($cumulative_counter) . " possible colors";


