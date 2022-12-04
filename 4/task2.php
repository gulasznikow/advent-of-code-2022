<?php
function overlap($minBoundary1, $maxBoundary1, $minBoundary2, $maxBoundary2): bool
{
    return (($minBoundary1 <= $maxBoundary2) && ($maxBoundary1>=$minBoundary2))
        || (($minBoundary2 <= $maxBoundary1) && ($maxBoundary2>=$minBoundary1));
}

$data = file(__DIR__.'/input.txt');

$overlappedPairs = 0;

foreach ($data as $entry)
{
    [$first, $second] = explode(',', $entry);
    [$min1, $max1] = explode('-', $first);
    [$min2, $max2] = explode('-', $second);

    $overlappedPairs += overlap((int)$min1, (int)$max1, (int)$min2, (int)$max2) ? 1 : 0;
}

print_r($overlappedPairs);