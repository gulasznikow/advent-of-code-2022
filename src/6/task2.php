<?php

$data = file(__DIR__ . '/input.txt')[0];

foreach (str_split($data) as $entryKey => $entry)
{
    $toCheck = str_split(substr($data,$entryKey, 14));

    $unique = array_unique($toCheck);

    if (count($unique) == count($toCheck)) {
        print_r(($entryKey+count($toCheck)).PHP_EOL);
        break;
    }
}
