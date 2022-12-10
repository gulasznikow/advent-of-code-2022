<?php

$data = file(__DIR__ . '/input.txt');

$directions = [
    'U' => [0,1],
    'D' => [0,-1],
    'R' => [1,0],
    'L' => [-1,0]
];
$rope = [];

$tailVisitedMap = [];

for ($x = 0; $x<=10; $x++)
{
    $rope[] = [0,0];
}
foreach ($data as $entry)
{
    $move = rtrim($entry);
    [$direction, $steps] = explode(' ', $move);
    $tailVisitedMap[$rope[9][0].$rope[9][1]] = '#';
    for ($i = 0; $i<$steps; $i++)
    {
        [$moveX, $moveY] = $directions[$direction];
        $rope[0][0] += (int)$moveX;
        $rope[0][1] += (int)$moveY;
        for ($j = 1; $j<=10; $j++)
        {
            followHead($j, $rope);
        }
        $tailVisitedMap[$rope[9][0].$rope[9][1]] = '#';

    }
}

function followHead(int $iteration, array &$rope)
{
    [$hx, $hy] = $rope[$iteration-1];
    [$tx, $ty] = $rope[$iteration];
    $moveX = $tx - $hx;
    $moveY = $ty - $hy;
    if ($moveX === 0 || $moveY === 0)
    {
        if (abs($moveX) >= 2){
            $rope[$iteration][0] -= moveTail($moveX);
        }

        if (abs($moveY) >= 2){
            $rope[$iteration][1] -= moveTail($moveY);
        }
    }elseif ([abs($moveX),abs($moveY)] !=[1,1])
    {
        $rope[$iteration][0] -= moveTail($moveX);
        $rope[$iteration][1] -= moveTail($moveY);
    }
}

function moveTail(int $move): int
{
    if ($move > 0)
    {
        return 1;
    }elseif ($move<0)
    {
        return -1;
    }else{
        return 0;
    }
}

print_r($rope);
print_r(count($tailVisitedMap));
