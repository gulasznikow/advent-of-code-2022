<?php

$data = file(__DIR__ . '/input.txt');

$directions = [
    'U' => [0,1],
    'D' => [0,-1],
    'R' => [1,0],
    'L' => [-1,0]
];

$hx = 0;
$hy = 0;
$tx = 0;
$ty = 0;
$tailVisitedMap = [];

foreach ($data as $entry)
{
    $move = rtrim($entry);
    [$direction, $steps] = explode(' ', $move);
    $tailVisitedMap[$tx.'-'.$ty] = '#';
    for ($i = 0; $i<$steps; $i++)
    {
        [$moveX, $moveY] = $directions[$direction];
        $hx += (int)$moveX;
        $hy += (int)$moveY;
        followHead($hx, $hy, $tx, $ty);
        print_r('NEW TAIL '.$tx.' '.$ty.PHP_EOL);
        $tailVisitedMap[$tx.'-'.$ty] = '#';

    }
}

function followHead(int $hx, int $hy, int &$tx, int &$ty)
{
    $moveX = $tx - $hx;
    $moveY = $ty - $hy;
    print_r('DIFF X Y '.$moveX.' '.$moveY.PHP_EOL);
    print_r('HEAD X Y '.$hx. ' '. $hy.PHP_EOL);
    if ($moveX === 0 || $moveY === 0)
    {
        if (abs($moveX) >= 2){
            $tx -= moveTail($moveX);
        }

        if (abs($moveY) >= 2){
            $ty -= moveTail($moveY);
        }
    }elseif ([abs($moveX),abs($moveY)] !=[1,1])
    {
        print_r('ELSEIF '. moveTail($moveX). ' '.moveTail($moveY).PHP_EOL);
        $tx -= moveTail($moveX);
        $ty -= moveTail($moveY);
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

print_r($tailVisitedMap);
print_r(count($tailVisitedMap));
