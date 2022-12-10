<?php

$data = file(__DIR__ . '/input.txt');

$x = 1;
$cycle = 1;
$cycles = [];

foreach ($data as $cmd)
{
    if(rtrim($cmd) === 'noop')
    {
        $cycles[$cycle] = $x;
        $cycle++;
    }else{
        [$command, $value] = explode(' ', rtrim($cmd));
        $cycles[$cycle] = $x;
        $cycles[$cycle+1] = $x;
        $x += (int)$value;
        $cycles[$cycle+2] = $x;
        $cycle += 2;
    }
}

$sum = 0;
foreach (range(20,220, 40) as $step)
{
    print_r(sprintf('Step %s = %s', $step, $cycles[$step]*$step).PHP_EOL);
    $sum+=$cycles[$step]*$step;
}

print_r($sum);
$screen = [];
foreach (range(0,5) as $vStep)
{
        $screen[$vStep] = [];
}
$pixel = 0;

foreach (range(0,5) as $vStep)
{
    foreach (range(0,39) as $hStep)
    {
        $position = $cycles[($vStep*40) + $hStep+1];
        if (inRange($hStep, $position))
        {
            $screen[$vStep][$hStep] = '#';
            continue;
        }
        $screen[$vStep][$hStep] = '.';
    }
}
print_r(PHP_EOL);

foreach ($screen as $row)
{
    foreach ($row as $pixel){
        print_r($pixel);
    }

    print_r(PHP_EOL);
}

function inRange($crtPos, $cyclePos): bool
{
    if (
        $crtPos>=($cyclePos-1)
        && $crtPos<=($cyclePos+1)
    )
    {
        return true;
    }

    return false;
}