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