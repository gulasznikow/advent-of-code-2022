<?php

use App\Utils\Memoize;
print_r(round(memory_get_usage()/1048576,2).''.' MB'.PHP_EOL);
$combinations = 0;
function pr($text)
{
    if (is_array($text)) {
        print_r($text);
    } else {
        print_r($text . PHP_EOL);
    }
}

require '../../vendor/autoload.php';

$data = file(__DIR__ . '/input.txt');

/** @var Valve[] $valves */
$valves = [];
$rates = [];


foreach ($data as $row) {
    $valve = substr($row, 6, 2);
    $rate = substr($row, 23, strpos($row, ';') - 23);
    $valves[$valve] = [];
    $rates[$valve] = $rate;
}

foreach ($data as $row) {
    $valve = substr($row, 6, 2);
    $right = explode('; tunnels lead to valves ',$row);
    if (count($right) === 1)
    {
        $right =  explode('; tunnel leads to valve ',$row);
    }

    foreach (explode(',', $right[1]) as $v)
    {
        $valves[$valve][] = trim($v);
    }
}



$solver = Memoize::make(function (string $valve, array $opened, int $minutesLeft) use (&$solver): array
{
    global $valves, $rates;
    if ($minutesLeft<=0) return [0, $opened];

    $highestPressureYield = 0;
    $highestOpened = $opened;

    if (!in_array($valve, $opened))
    {
        $yield = ($minutesLeft - 1) * $rates[$valve];

        $newOpened = $opened;
        $newOpened[] = $valve;
        sort($newOpened);
        foreach ($valves[$valve] as $tunnel)
        {
            if ($yield!=0)
            {
                $a = $solver($tunnel, $newOpened, $minutesLeft-2);
                if (($yield+$a[0]) > $highestPressureYield)
                {
                    $highestOpened = $a[1];
                    $highestPressureYield = $yield + $a[0];
                }
            }
            $b = $solver($tunnel, $opened, $minutesLeft-1);

            if ($b[0] > $highestPressureYield)
            {
                $highestPressureYield = $b[0];
                $highestOpened = $b[1];
            }
        }
    }

    return [$highestPressureYield, $highestOpened];
});

$result = $solver('AA',[],30);

pr($result[0].PHP_EOL);
pr($result[1]);
print_r(round(memory_get_usage()/1048576,2).''.' MB'.PHP_EOL);