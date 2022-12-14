<?php

require '../../vendor/autoload.php';

$data = file(__DIR__ . '/input.txt');

$cave = [];
$sandCount = 0;

//we populate cave with all the rocks
foreach ($data as $row)
{
    $coords = explode(' -> ', trim($row));

    foreach ($coords as $coord)
    {
        foreach (range(1, count($coords)-1) as $step)
        {
            [$pv, $ph] = explode(',', $coords[$step-1]);
            [$nv, $nh] = explode(',', $coords[$step]);
            if ($nv < $pv)
            {
                for ($y = $pv; $y  >= $nv; $y--)
                {
                    $cave[$ph][$y] = '#';
                }
            }elseif ($ph<$nh)
            {
                for ($x = $ph; $x <= $nh; $x++)
                {
                    $cave[$x][$pv] = '#';
                }
            }
        }
    }
}
$bottom = (max(array_keys($cave)));
print_r($cave);

//we have infinite loop that moves sand around
while(true)
{
    $startX = 500;
    $startY = 0;

    while(true)
    {
        if ($startY>$bottom)
        {
            //if we reached abyss we stop both loops
            print_r($sandCount);
            die();
        }

        if (!isset($cave[$startY+1][$startX]))
        {
            //we can go bottom
            $startY+=1;
            continue;
        }

        if (!isset($cave[$startY+1][$startX-1]))
        {
            //we can go bottom left
            $startY +=1;
            $startX -=1;
            continue;
        }

        if (!isset($cave[$startY+1][$startX+1]))
        {
            //we can go bottom right
            $startY +=1;
            $startX +=1;
            continue;
        }

        //if we cant move anywhere we break this loop and add sand to specifiec coordinates
        $cave[$startY][$startX] = 'o';
        $sandCount++;
        break;
    }

}
