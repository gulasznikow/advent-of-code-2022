<?php

$data = file(__DIR__.'/input.txt')[0];
foreach (str_split($data) as $entryKey => $entry)
{
    $unique = array_unique(str_split(substr($data,$entryKey, 4)));

    if (count($unique) == 4) {
        print_r(($entryKey+4).PHP_EOL);
        break;
    }
}
