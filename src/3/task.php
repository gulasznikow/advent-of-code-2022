<?php

$data = file(__DIR__ . '/input.txt');

$sum = 0;

foreach ($data as $entry)
{
    $trimmed = trim($entry);
    $firstCompartment = str_split(substr($trimmed, 0, floor(strlen($trimmed)/2)));
    $secondCompartment = str_split(substr($trimmed, floor(strlen($trimmed)/2)));
    $common = implode(array_unique(array_intersect($firstCompartment, $secondCompartment)));

    if (ctype_upper($common))
    {
        $sum += ord($common) - 64+ 26;
    } else {
        $sum += ord($common)- 96;
    }
}

print_r($sum.PHP_EOL);