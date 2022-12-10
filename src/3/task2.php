<?php

$data = file(__DIR__ . '/input.txt');

$sum = 0;

foreach (array_chunk($data, 3) as $entry)
{
    $common = trim(implode(array_unique(array_intersect(str_split($entry[0]), str_split($entry[1]), str_split($entry[2])))));
    if (ctype_upper($common))
    {
        $sum += ord($common) - 64 + 26;
    } else {
        $sum += ord($common)- 96;
    }
}

print_r($sum.PHP_EOL);