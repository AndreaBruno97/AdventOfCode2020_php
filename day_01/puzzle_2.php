<?php
const TARGET_VALUE = 2020;

// Read file, content in $list array
$file = fopen("input.txt", "r") or die("Error while opening file");
while(!feof($file)){
    $list[] = intval(fgets($file));
}
fclose($file);
sort($list);

/*
Compute the sum:
Each number in the sorted list is summed to the ones after it.
When the sum is over the target, there's no need to try the other
elements in the inner loop
*/
$total = 0;
for ($i = 0; $i < count($list) - 2 && $total != TARGET_VALUE; $i++) {
    $first = $list[$i];

    for ($j = $i+1; $j < count($list) - 1 && $total < TARGET_VALUE; $j++) {
        $second = $list[$j];

        for ($k = $j+1; $k < count($list) && $total < TARGET_VALUE; $k++) {
            $third = $list[$k];

            $total = $first + $second + $third;
            if($total == TARGET_VALUE){
                // Sum found
                echo $first . " + " . $second . " + " . $third . " = " . $total;
                echo "\nTheir product is " . ($first * $second * $third);
            }
        }

        if($total != TARGET_VALUE)
            $total = 0;
    }

    if($total != TARGET_VALUE)
        $total = 0;
}

if($total != TARGET_VALUE){
    // Sum not found
    echo "There are no three numbers that sum to " . TARGET_VALUE;
}