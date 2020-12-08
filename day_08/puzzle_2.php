<?php

class Instruction{
    public $instruction;
    public $value;
    public $visited;

    public function __construct($a, $b, $c){
        $this->instruction = $a;
        $this->value = $b;
        $this->visited = $c;
    }
}

function runProgram($program){
    $index = 0;
    $accumulator = 0;
    $program_is_complete = false;

    while(true){

        if ($index == count($program)) {
            // The program arrived at the end
            $program_is_complete = true;
            break;

        }
        $current_instruction = $program[$index];

        if($current_instruction->visited == 1) {
            // Termiantion condition: we've already visited this instruction
            break;
        }

        $current_instruction->visited = 1;

        $next_index_offset = 1;
        if ($current_instruction->instruction == "acc") {
            $accumulator += $current_instruction->value;
        }
        else if ($current_instruction->instruction == "jmp"){
            $next_index_offset = $current_instruction->value;
        }

        $index += $next_index_offset;

    }

    return array($accumulator, $program_is_complete);
}


// Read file, content in $list array
$file = fopen("input.txt", "r") or die("Error while opening file");
while(!feof($file)){
    $list[] = fgets($file);
}
fclose($file);


$program = [];
foreach($list as $line_dirty){
    $line = str_replace("\n", "", $line_dirty);
    list($instruction, $value) = explode(" ", $line);

    /*
    Each instruction is saved in an array, so that their relative position
    is fixed via their index, and the value is an object composed by
        the name of the instruction,
        the numerical value associated to it,
        and a flag that is 0 if the instruction hasn't been visited yet
    */
    $program[] = new Instruction($instruction, $value, 0);
}

$accumulator = 0;
for($index = 0; $index < count($program); $index++){
    $old_instruction = $program[$index]->instruction;

    // Set all the visited flag to 0
    foreach ($program as $iter_instr) {
        $iter_instr->visited = 0;
    }


    // Change the possibly corrupted instruction
    if($program[$index]->instruction == "jmp") {
        $program[$index]->instruction = "nop";
    }
    else if($program[$index]->instruction == "nop") {
        $program[$index]->instruction = "jmp";
    }
    else{
        continue;
    }

    list($accumulator, $program_is_complete) = runProgram($program);

    if ($program_is_complete == true) {
        // The program was successful
        break;
    }

    $program[$index]->instruction = $old_instruction;
}



echo "The last valid value of the accumulator is " . $accumulator;