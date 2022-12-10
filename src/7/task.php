<?php

$data = file(__DIR__ . '/input.txt');

$index = 0;

$filesystem = [];
$currentDirectory = '';

while (isset($data[$index]))
{
    $line = rtrim($data[$index]);
    if (str_starts_with($line, '$'))
    {
        if (substr($line,2,2) == 'cd')
        {
            if (substr($line,5,1) === '/')
            {
                print_r('ROOT '.$currentDirectory.PHP_EOL);
                $currentDirectory = 'root';
            }elseif(substr($line,5,2) === '..')
            {
                $newCurrentDirectory = substr($currentDirectory, 0, strripos($currentDirectory,'/'));
                print_r('UP '.$currentDirectory.' ^ '.$newCurrentDirectory.PHP_EOL);
                $currentDirectory = $newCurrentDirectory;
            }else{
                $newCurrentDirectory = $currentDirectory.'/'.substr($line,5);
                print_r('CD '.$currentDirectory.' -> '.$newCurrentDirectory.PHP_EOL);
                $currentDirectory = $newCurrentDirectory;
            }
        }elseif (substr($line,2,2) == 'ls')
        {
            $lsIndex = $index+1;

            while(isset($data[$lsIndex]) && !str_starts_with($data[$lsIndex], '$'))
            {
                if (str_starts_with($data[$lsIndex], 'dir'))
                {
                    $filesystem[$currentDirectory][rtrim(substr($data[$lsIndex],4))] = [];
                }else{
                    [$size, $filename] = explode(' ',$data[$lsIndex]);
                    $filesystem[$currentDirectory][rtrim($filename)] = (int) $size;
                }
                $lsIndex++;
            }
            $index = $lsIndex-1;
        }
    }
//    print_r($currentDirectory.PHP_EOL);
    $index++;
}

$total = 0;
$sizes = [];
foreach ($filesystem as $key => $fileEntry)
{
    $sizes[$key] = 0;
    foreach ($fileEntry as $entry)
    {
        if (!empty($entry))
        {
            $sizes[$key] += $entry;
        }
    }
}

foreach ($sizes as $key => $size)
{
    foreach ($sizes as $key2 => $size2)
    {
        if ($key!== $key2 && str_starts_with($key2, $key))
        {
            $sizes[$key] += $size2;
        }
    }
}
$finaltotal = 0;
foreach ($sizes as $size)
{
    if ($size < 100000) $finaltotal+=$size;
}
print_r($finaltotal.PHP_EOL);

$totalSize = $sizes['root'];
$totalFreeSpace = 70000000 - $sizes['root'];
$toFree = 30000000 - $totalFreeSpace;
print_r($totalSize.PHP_EOL);
print_r($totalFreeSpace.PHP_EOL);
print_r($toFree.PHP_EOL);

$candidates = [];
foreach ($sizes as $key => $entry)
{
    if ($entry >= $toFree) $candidates[$key] = $entry;
}

print_r($candidates);
print_r(min($candidates));
