<?php

// Read file, content in $list array
$file = fopen("input.txt", "r") or die("Error while opening file");
while(!feof($file)){
    $list[] = fgets($file);
}
fclose($file);

$id_list = [];

foreach($list as $line_dirty){
    // Delete final space
    $line = str_replace("\r\n", "", $line_dirty);

    // Row is composed by the first 7 characters, Column is the lst three
    $row_string = substr($line, 0, 7);
    $column_string = substr($line, -3);

    /*
    Binary search strings correspond to the binary representation
    of row and column position, with
        F->0, B->1 for row,
        L->0, R->1 for column
    */
    $row_binary_string = str_replace(array("F", "B"), array("0", "1"), $row_string);
    $column_binary_string = str_replace(array("L", "R"), array("0", "1"), $column_string);

    // Convert the string (in binary) to the row's and column's numbers (in decimal)
    $row = bindec($row_binary_string);
    $column = bindec($column_binary_string);
    $id = ( $row * 8 ) + $column;

    $id_list[] = $id;
}

$my_row = -1;
$my_column = -1;
$my_id = -1;

/*
id_list, when sorted, contains all the IDs from a to b, except the target ID x:
a, a+1, a+2, [...], x-2, x-1, (Here there's no x) x+1, x+2, [...], b-2, b-1, b
 */
sort($id_list);
for($index = 1; $index < count($id_list); $index++){
    $current_id = $id_list[$index];
    $previous_id = $id_list[$index - 1];

    if($current_id - $previous_id != 1){
        /*
         Found the gap:
                current_id is x+1, the next ID
                id_list[index-1] is x-1, the previous ID
        */
        $my_id = $current_id - 1;
        $my_column = $my_id % 8;
        $my_row = intval( ($my_id - $my_column) / 8 );
        break;
    }
}

echo "My seat ID is " . $my_id . " in row " . $my_row . " and column " . $my_column;