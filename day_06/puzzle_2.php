<?php

// Read file, all in one line
$content = file_get_contents("input.txt");
//Split the input into groups, since each one is divided by two newlines
$content = explode("\r\n\r\n", $content);

$total = 0;
foreach ($content as $group){
    // I create a list of answers of each person in the group
    $group = explode("\r\n", $group);

    $group_set = array();
    $is_first_row = true;

    foreach ($group as $answer) {
        // Extract the set of answers for the current row
        $answer_set = array();
        foreach (str_split($answer) as $char){
            $answer_set[$char] = true;
        }

        if ($is_first_row == true){
            // This is the first row, I don't have other rows to compare it to
            $group_set = $answer_set;
            $is_first_row = false;
        }
        else{
            // Compute the intersection between the current answers and the others
            $group_set = array_intersect_assoc($group_set, $answer_set);
        }
    }

    $total += count($group_set);
}

echo "The total count is " . $total;