<?php

$data = str_split(file(__DIR__.'/input.txt')[0]);

foreach ($data as $entryKey => $entry)
{
    $toCheck = [];
    for($i=$entryKey; $i <= min(count($data), $entryKey+13); $i++)
    {
        $toCheck[] = $data[$i];
    }
    $unique = array_unique($toCheck);

    if (count($unique) == count($toCheck)) {
        print_r(($entryKey+count($toCheck)).PHP_EOL);
        break;
    }
}
