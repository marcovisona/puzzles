#/bin/sh

gcc c_n_queens_solver.c -march=native -O2 -o c_n_queens_solver
# gcc c_n_queens_solver.c -o c_n_queens_solver
strip c_n_queens_solver

for i in {8..12}; do
    echo "=== testing $i ==="

    echo "c: $(./c_n_queens_solver $i)"

    if [[ -x $(which node) ]]
        then
        echo "node: $(node javascript_n_queens_solver.js $i)"
    fi

    if [[ -x $(which php) ]]
        then
        echo "php: $(php php_n_queens_solver.php $i)"
    fi

    if [[ -x $(which luajit) ]]
        then
        echo "lua : $(board_size=$i luajit luajit_n_queens_solver.lua)"
    fi

    if [[ -x $(which pypy) ]]
        then
        echo "pypy: $(pypy python_n_queens_solver.py $i)"
    fi

    if [[ -x $(which python) ]]
        then
        echo "python: $(python python_n_queens_solver.py $i)"
    fi

    if [[ -x $(which scala) ]]
        then
        echo "scala: $(scala scala_n_queens_solver.scala $i)"
    fi

    if [[ -x $(which ruby) ]]
        then
        echo "ruby: $(ruby ruby_n_queens_solver.rb $i)"
    fi

    if [[ -x $(which dart) ]]
    then
      echo "dart: $(dart dart_n_queens_solver.dart $i)"
    fi

    echo "\n\n"

done
