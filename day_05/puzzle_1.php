<?php

// Read file, content in $list array
$file = fopen("input.txt", "r") or die("Error while opening file");
while(!feof($file)){
    $list[] = fgets($file);
}
fclose($file);

$max_row = -1;
$max_column = -1;
$max_id = -1;


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

    if( $id > $max_id ){
        $max_id = $id;
        $max_row = $row;
        $max_column = $column;
    }
}

echo "The highest seat ID is " . $max_id . " in row " . $max_row . " and column " . $max_column;