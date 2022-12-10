<?php

$data = file(__DIR__ . '/input.txt');

$elves = [];
$biggestCount = 0;
$biggestCountElfIndex = 1;
$elfCaloriesCount = 0;
$elfIndex = 1;
foreach ($data as $key => $entry)
{
    if (empty(trim($entry))){
        if ($biggestCount < $elfCaloriesCount)
        {
            $biggestCountElfIndex = $elfIndex;
            $biggestCount = $elfCaloriesCount;
        }
        $elves[] = ['elfIndex' => $elfIndex, 'amount' => $elfCaloriesCount];
        $elfIndex++;
        $elfCaloriesCount = 0;
        continue;
    }
    $elfCaloriesCount += $entry;

}

print_r($biggestCount.PHP_EOL);
print_r($biggestCountElfIndex.PHP_EOL);
print_r($elves);
$sortedElves = array_multisort(array_column($elves, 'amount'), SORT_DESC, $elves);
print_r($elves[0]['amount'] + $elves[1]['amount'] + $elves[2]['amount']);
//$sum = array_reduce($elves, function ($v, $w){
//    return $v + $w['amount'];
//});
//print_r($sum.PHP_EOL);