
function displayQueens(solution) {
    for(var row=0; row < solution.length; row++) {
        for(var col=0; col < solution.length; col++) {
            var elementOut = "_ ";
            solution.forEach(function(coordinate) {
                if((coordinate[0] == col) && (coordinate[1] == row)) {
                    elementOut = "Q ";
                }
            });
            process.stdout.write(elementOut)
        }
        console.log()
    }
}


function isValidPosition(nQueenPositions, newPosition){

    numOfChecks++;

    for(var i=0; i < nQueenPositions.length; i++){
        var existingPosition = nQueenPositions[i]

        if( existingPosition[1] === newPosition[1] || existingPosition[0] === newPosition[0] ){
            return false 
        }
        var rowDifference = Math.abs(newPosition[1]-existingPosition[1]);
        var columnDifference = Math.abs(newPosition[0]-existingPosition[0]);

        if(rowDifference === columnDifference) {
            return false;
        }
    }
    return true 
}

function solve(nQueensSize, nQueenPositions, currentColumn) {
    if( currentColumn === nQueensSize && nQueenPositions.length === nQueensSize) {
        return [nQueenPositions];
    }

    var solutions = [];

    for(var row = 0; row < nQueensSize; row++) {
        var newPosition = [currentColumn, row];

        if(isValidPosition(nQueenPositions,newPosition)) {
            var newNQueenPositions = nQueenPositions.concat();
            newNQueenPositions.push(newPosition);

            var solution = solve(nQueensSize, newNQueenPositions, currentColumn+1);
            for(var i=0; i<solution.length; i++) solutions.push(solution[i])
        }
    }

    return solutions;
}


// MAIN

if(process.argv.length < 3) {
    console.log("usage: node javascript_n_queens_solver.js BOARD_SIZE [-d]");
    process.exit();
}

var numOfChecks = 0;
var nQueensSize = +process.argv[2] || 0
var displaySolutions = process.argv[3] === '-d'
var startTime = Date.now()
var solutions = solve(nQueensSize, [], 0)
var endTime = Date.now()

var elapsedTime = endTime - startTime

console.log("N-Queens Found %d solutions in %ds on a %dx%d board", solutions.length, elapsedTime/1000, nQueensSize, nQueensSize);
console.log("Number of checks: %d", numOfChecks);

if(displaySolutions) {
    var counter = 1;
    solutions.forEach(function(solution) {
        console.log("Solution", counter);
        displayQueens(solution);
        counter++;
    });
}
