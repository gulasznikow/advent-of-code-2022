<?php

require '../../vendor/autoload.php';
require 'Algo/Dijkstra.php';

$directions = [
    [0, -1],
    [-1, 0], [1, 0],
    [0,1 ],
];

$data = file(__DIR__ . '/input.txt');

$map = [];
$start = [0,0];
$end = [0,0];

foreach ($data as $y => $row) {
    foreach (str_split(trim($row)) as $x => $column) {
        if ($column === 'S') {
            $map[$x][$y] = 'a';
            $start = [$x, $y];
            continue;
        }
        if ($column === 'E') {
            $map[$x][$y] = 'z';
            $end = [$x, $y];
            continue;
        }
        $map[$x][$y] = $column;
    }
}

//Add starting point to queue
$q = new SplQueue();

//Put end coordinates for part 2
$q->enqueue([0,$start]);
$v[$start[0].'-'.$start[1]] = 1;

$step = 0;

//We go through all elements until queue is empty, or we found (more likely) target coords, basically botched BFS algorithm
while($q->count()>0)
{
    //Take first queue element and decompose it to weight and coords
    $e = $q->shift();
    $i = $e[0];
    $x = $e[1][0];
    $y = $e[1][1];
    //We iterate trough every direction
    foreach ($directions as $direction)
    {
        $newX = $x+$direction[0];
        $newY = $y+$direction[1];

        //Check if visited coords are out of bound
        if ($newX < 0 || $newY < 0 || $newX>=count($map) || $newY>=count($map[0])) continue;

        //Check if we visited it already
        if (isset($v[$newX.'-'.$newY])){
          continue;
        }

        //Check if its even traversable to
        if ((ord($map[$newX][$newY]) - ord($map[$x][$y])) > 1 ) continue;

        //Check if the visited coords are the destination coords and end it
        //Compare new coords character with 'a' for part 2 to find closest a
        if ($newX === $end[0] && $newY === $end[1])
        {
            print_r($i+1);
            die();
        }
        //Add visited coords to visited array and push new entry to queue with distance +1 and new coords
        $v[$newX.'-'.$newY]= 1;
        $q->push([$i+1,[$newX,$newY]]);
    }
}