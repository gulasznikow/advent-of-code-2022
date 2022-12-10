<?php

$data = file(__DIR__ . '/input.txt');

$stacks = [];
foreach ($data as $entryKey => $entry)
{
    if ($data[$entryKey+1] === PHP_EOL)
    {
        $stacksIndexes = array_slice(explode(' ',str_replace('   ', ' ', $entry)),1);
        foreach ($stacksIndexes as $index)
        {
            $stacks[$index-1 ] = [];
        }
        break;
    }
}
$dataStartIndex = 0;
foreach ($data as $entryKey => $entry)
{
    if ($data[$entryKey+1] === PHP_EOL)
    {
        $dataStartIndex = $entryKey+2;
        break;
    }
    $entry = str_replace('    ', '|', $entry);
    $entry = str_replace([' [','[',']'], '', $entry);
    foreach (array_slice(str_split($entry),0,9) as $key => $value)
    {
        if ($value === '|') continue;
        array_unshift($stacks[$key], $value);
    }
}
foreach (array_slice($data, $dataStartIndex) as $entry)
{
    $operations = explode(' ', $entry);
    $toInsert = [];
    for ($i = 0; $i < $operations[1]; $i++)
    {
        $toInsert[] = array_pop($stacks[$operations[3] - 1]);
    }
    foreach (array_reverse($toInsert) as $insert)
    {
        $stacks[$operations[5] - 1][] = $insert;
    }
}
print_r(implode('',array_map(function ($array){
    return array_pop($array);
}, $stacks)));