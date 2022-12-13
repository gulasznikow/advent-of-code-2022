<?php

require '../../vendor/autoload.php';

$data = file(__DIR__ . '/input.txt');

$left = [];
$right = [];
$indices = [];

$dataWithNoEmptyLines = [];

//Fuckery to clean up input with eval atrocities, probably there does exist more humane way to parse input apart from harcoding it
foreach (array_chunk($data,3) as $key => $step)
{
    eval('$left = '.$step[0].';');
    eval('$right = '.$step[1].';');
    $dataWithNoEmptyLines[$key*2] = $left;
    $dataWithNoEmptyLines[$key*2+1] = $right;
}

//We go by pairs and save indexes+1 of right order ones
foreach (array_chunk($dataWithNoEmptyLines,2) as $key => $step)
{
    $v = leftIsSmaller($step[0],$step[1]);
    if ($v===true)
    {
        $indices[] = $key+1;
    }

}

//BEHOLD, sorting func
function leftIsSmaller(mixed $left,mixed $right): ?bool
{
    //If both are values then we compare them
    if (is_int($left) && is_int($right))
    {
        if ($left<$right) {
            return true;
        }elseif ($left===$right) {
            return null;
        }else{
            return false;
        }
    //If both are arrays we parse tem
    } elseif (is_array($left) && is_array($right))
    {
        //We take the smallest size to parse value by value
        $min = min(count($left), count($right));
        for ($step = 0; $step<$min; $step++)
        {
            $rec = leftIsSmaller($left[$step], $right[$step]);

            //If one of values is smaller than we return it, otherwise both are equals ,and then we proceed
            if ($rec!==null) return $rec;
        }

        //We check sizes to determine which one could be smaller per specifications
        if (count($left)<count($right)) return true;
        if (count($right)<count($left)) return false;
        return null;
    //Here we parse in case one value is value and other one is an array
    }elseif (is_array($left) && is_int($right))
    {
        return leftIsSmaller($left, [$right]);
    }else{
        return leftIsSmaller([$left], $right);
    }
}

print_r('Sum : '.array_sum($indices).PHP_EOL);

//For part 2 we add 2 bonus elements
$dataWithNoEmptyLines[] = [[2]];
$dataWithNoEmptyLines[] = [[6]];

//Thanks to our awesome skills, we have a function we can use in usort as a callback
usort($dataWithNoEmptyLines, function ($left, $right){

    $result = leftIsSmaller($left, $right);

    if ($result === true) return -1;
    if ($result === false) return 1;
    return 0;
});

//We search for our bonus elements and multiply them to get part 2 result
$first = array_search([[2]], $dataWithNoEmptyLines)+1;
$second = array_search([[6]], $dataWithNoEmptyLines)+1;
print_r('Dividers result '.$first*$second);