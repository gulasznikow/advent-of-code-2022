<?php

$data = str_split(file(__DIR__.'/input.txt')[0]);
foreach ($data as $entryKey => $entry)
{
    $unique = array_unique(
        [
            $data[$entryKey],
            $data[$entryKey+1],
            $data[$entryKey+2],
            $data[$entryKey+3]
        ]
    );

    if (count($unique) == 4) {
        print_r(($entryKey+4).PHP_EOL);
        break;
    }
}
