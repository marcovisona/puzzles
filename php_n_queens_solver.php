<?php 

function displayQueens($solution) {
    $solutionCount = count($solution);
    for ($row=0; $row < $solutionCount; $row++) {     
        for ($col=0; $col < $solutionCount; $col++) { 
            $elementOut = "_ ";
            foreach ($solution as $coordinate) {
                if ($coordinate[0] === $col && $coordinate[1] === $row) {
                    $elementOut="Q ";
                }
            }
            echo $elementOut;
        }
        echo "\n";
    }
}

function isValidPosition($nQueenPositions, $newPosition){
    global $numOfChecks;
    $numOfChecks++;
    $nQueenPositionsCount = count($nQueenPositions);
    for($i=0; $i < $nQueenPositionsCount;$i++){
        $existingPosition = $nQueenPositions[$i];

        if( $existingPosition[1] === $newPosition[1] || $existingPosition[0] === $newPosition[0] ){
            return false;
        }
        $rowDifference = abs($newPosition[1]-$existingPosition[1]);
        $columnDifference = abs($newPosition[0]-$existingPosition[0]);

        if($rowDifference === $columnDifference) {
            return false;
        }
    }
    return true;
}

function solve($nQueensSize, $nQueenPositions, $currentColumn) {

    if( $currentColumn === $nQueensSize && count($nQueenPositions) === $nQueensSize) {
        $solution = [$nQueenPositions];
        return $solution;
    }

    $solutions = [];

    for($row = 0; $row < $nQueensSize; $row++) {
        $newPosition = [$currentColumn, $row];

        if(isValidPosition($nQueenPositions,$newPosition)) {
            $newNQueenPositions = $nQueenPositions;
            array_push($newNQueenPositions, $newPosition);
            
            $solution = solve($nQueensSize, $newNQueenPositions, $currentColumn+1);
            $solutionCount = count($solution);
            for($i=0; $i<$solutionCount; $i++) {
                array_push($solutions, $solution[$i]);
            }

        }
    }

    return $solutions;
}


// MAIN

if(count($argv) < 2) {
    echo ("usage: php php_n_queens_solver.js BOARD_SIZE [-d]");
    exit();
}

$numOfChecks =0;

$nQueensSize = intval($argv[1]);
$displaySolutions = $argv[2] === '-d';
$startTime = microtime(true);
$init = [];
$solutions = solve($nQueensSize, $init, 0);
$endTime = microtime(true);

$elapsedTime = $endTime - $startTime;
printf("N-Queens Found %d solutions in %fs on a %dx%d board\n", count($solutions), $elapsedTime, $nQueensSize, $nQueensSize);
printf("Number of checks: %d\n", $numOfChecks);
if($displaySolutions) {
    $counter = 1;
    foreach ($solutions as $solution) {
        echo ("Solution $counter\n");
        displayQueens($solution);
        $counter++;
    }
}
