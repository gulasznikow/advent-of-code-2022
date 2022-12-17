<?php

$data = file(__DIR__ . '/input.txt');
function pr($text)
{
    if (is_array($text)) {
        print_r($text);
    } else {
        print_r($text . PHP_EOL);
    }
}

class Piece
{
    public static function make($iter, $height): array
    {
        return match ($iter) {
            0 => [[2, $height], [3, $height], [4, $height], [5, $height]],
            1 => [[3, $height+2], [2, $height+1], [3, $height+1], [4, $height+1], [3, $height]],
            2 => [[2, $height], [3, $height], [4, $height], [4,$height+1], [4, $height+2]],
            3 => [[2, $height], [2, $height+1], [2, $height+2], [2, $height+3]],
            4 => [[2, $height+1], [2, $height], [3, $height+1], [3, $height]],
        };
    }
}

function moveToLeft($shape): array
{
    foreach ($shape as $c) {
        if ($c[0] === 0) return $shape;
    }
    $newShape = [];
    foreach ($shape as $c) {
        $newShape[] = [$c[0] - 1, $c[1]];
    }

    return $newShape;
}

function moveToRight($shape): array
{
    foreach ($shape as $c) {
        if ($c[0] === 6) return $shape;
    }
    $newShape = [];
    foreach ($shape as $c) {
        $newShape[] = [$c[0] + 1, $c[1]];
    }

    return $newShape;
}

function moveDown($shape): array
{
    $newShape = [];
    foreach ($shape as $c) {
        $newShape[] = [$c[0], $c[1]-1];
    }

    return $newShape;
}

function moveUp($shape): array
{
    $newShape = [];
    foreach ($shape as $c) {
        $newShape[] = [$c[0], $c[1]+1];
    }

    return $newShape;
}
$directions = str_split(trim($data[0]));
$tetrisBoard = [];

function sC($x,$y): string
{
    return $x.'-'.$y;
}

foreach (range(0,6) as $s)
{
    $tetrisBoard[sC($s,0)] = [$s, 0];
}

function canBeMoved($shape): bool
{
    global $tetrisBoard;

    foreach ($shape as $c)
    {
        if (isset($tetrisBoard[sC($c[0],$c[1])])) return false;
    }

    return true;
}

function addRockToBoard($shape): void
{
    global $tetrisBoard, $rocks;

    foreach ($shape as $s)
    {
        $tetrisBoard[sC($s[0],$s[1])] = [$s[0], $s[1]];
    }

    $rocks++;
}

function maxHeight(): int
{
    global $tetrisBoard;
    return max(array_column($tetrisBoard, 1));
}

function debugBreak(): void
{
    readline('Click to move forward');
}

function showBoard()
{
    global $tetrisBoard;
    $tmpBoard = [];
    foreach (range(500, 0, -1) as $row)
    {
        foreach (range(0,6) as $col)
        {
            if (isset($tetrisBoard[sC($col, $row)]))
            {
                print_r('#');
            } else {
                print_r('.');
            }
        }
        print_r(PHP_EOL);
    }
}
$rocks = 0;
$top = 0;
$iteration = 0;
$visibleFromTop = [];
$shapeIteration = 0;

$start = microtime(true);
//while ($rocks < 1000000000000)
while ($rocks < 2022)
{
    $shape = Piece::make($shapeIteration%5, $top+4);
//    showBoard();
//    debugBreak();
    while (true)
    {
        $dir = $directions[$iteration];

        if ($dir==='<')
        {
            $shape = moveToLeft($shape);
            if (!canBeMoved($shape)) $shape = moveToRight($shape);
        } else {
            $shape = moveToRight($shape);
            if (!canBeMoved($shape)) $shape = moveToLeft($shape);
        }

        $iteration = ($iteration+1)%count($directions);

        $shape = moveDown($shape);

        if (!canBeMoved($shape))
        {
            $shape = moveUp($shape);
            addRockToBoard($shape);

            $top = max($top, maxHeight());

            break;
        }
    }
    $shapeIteration++;
}
pr(microtime(true) - $start);
pr(maxHeight());