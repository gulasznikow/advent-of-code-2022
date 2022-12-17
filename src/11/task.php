<?php
require '../../vendor/autoload.php';
$data = file(__DIR__ . '/input.txt');

/** @var Monkey[] $monkeys */
$monkeys = [];

foreach (array_chunk($data, 7) as $chunk)
{
    $monkey = new Monkey();
    foreach (explode(', ',substr(trim($chunk[1]),16)) as $item)
    {
        $monkey->items[] = $item;
    };

    $monkey->operation = substr(trim($chunk[2]),11);
    $monkey->divisibleTest = (int)substr(trim($chunk[3]), 19);

    $monkey->throws = [
        true => (int)substr(trim($chunk[4]), 25),
        false => (int)substr(trim($chunk[5]), 25)
    ];

    $monkeys[] = $monkey;
}
foreach (range(0,19) as $step) {
    foreach ($monkeys as $monkey) {
        $monkey->processItems($monkeys);
    }
}
$activities = getActivitiesState($monkeys);

print_r($activities);

$numbers = array_unique($activities);

rsort($numbers);

print_r($numbers[0] * $numbers[1]);
function getActivitiesState($monkeys)
{
    $activities = [];
    foreach ($monkeys as $key => $monkey)
    {
        $activities[$key] = $monkey->activity;
    }

    return $activities;
}
class Monkey
{
    public array $items = [];
    public string $operation = '';
    public int $divisibleTest = 1;
    public int $activity = 0;
    public array $throws = [
        true => 0,
        false => 1
    ];

    function processItems(array &$monkeys): void
    {
        $operation = str_replace('new', '$newWorryLevel', str_replace('old', '$item', $this->operation,)).';';

        foreach ($this->items as $item)
        {
            $this->activity++;
            $newWorryLevel = 0;
            eval($operation);

//            print_r('NEW WORRY LEVEL '.$newWorryLevel.PHP_EOL);

            $test = ($newWorryLevel/3) % $this->divisibleTest;

//            print_r('IS DIVISIBLE '.$newWorryLevel.' % '.$this->divisibleTest. ' = '. $test.PHP_EOL);

//            print_r(((int) floor($newWorryLevel / 3)).' GOES TO MONKEY '.$this->throws[$test===0].PHP_EOL);
            /** @var Monkey $monkeyTarget */
            $monkeyTarget = $monkeys[$this->throws[$test===0]];
            array_shift($this->items);
            $monkeyTarget->items[] = floor($newWorryLevel/3);
//            print_r($monkeyTarget);
        }
    }
}


class Item
{
    public int $worryLevel = 0;
}