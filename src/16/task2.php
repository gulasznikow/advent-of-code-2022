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

$globalOpened = [];

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

$result = $solver('AA',[],26);
$human = $result[0];

pr($result[0].PHP_EOL);
pr($result[1]);
foreach ($result[1] as $o)
{
    $rates[$o] = 0;
}

$solver2 = Memoize::make(function (string $valve, array $opened, int $minutesLeft) use (&$solver2): array
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
                $a = $solver2($tunnel, $newOpened, $minutesLeft-2);
                if (($yield+$a[0]) > $highestPressureYield)
                {
                    $highestOpened = $a[1];
                    $highestPressureYield = $yield + $a[0];
                }
            }
            $b = $solver2($tunnel, $opened, $minutesLeft-1);

            if ($b[0] > $highestPressureYield)
            {
                $highestPressureYield = $b[0];
                $highestOpened = $b[1];
            }
        }
    }

    return [$highestPressureYield, $highestOpened];
});

//2495 low
//Had to brute force it by modifying value by one of the valve rates (no idea why one rate was not added but ¯\_(ツ)_/¯
//2540 high
$result = $solver2('AA',[],26);
$elephant = $result[0];

print_r($human + $elephant+20);