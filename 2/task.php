<?php

enum Symbol: int
{
    case ROCK = 1;
    case PAPER = 2;
    case SCISSORS = 3;

    public static function tryFromCharacter(string $symbol): Symbol
    {
        return match (true){
            str_contains($symbol,'X'), str_contains($symbol,'A') => self::ROCK,
            str_contains($symbol,'Y'), str_contains($symbol,'B') => self::PAPER,
            str_contains($symbol,'Z'), str_contains($symbol,'C') => self::SCISSORS,
            default => print_r($symbol)
        };
    }
}

$winMatrix = [
    Symbol::ROCK->name => [
        Symbol::PAPER->name => 1,
        Symbol::ROCK->name => 4,
        Symbol::SCISSORS->name => 7,
    ],
    Symbol::PAPER->name => [
        Symbol::SCISSORS->name=> 2,
        Symbol::PAPER->name => 5,
        Symbol::ROCK->name => 8,
    ],
    Symbol::SCISSORS->name => [
        Symbol::ROCK->name => 3,
        Symbol::SCISSORS->name => 6,
        Symbol::PAPER->name => 9,
    ]
];
$data = file(__DIR__.'/input.txt');
$score = 0;

foreach ($data as $entry)
{
    [$firstColumn, $secondColumn] = explode(' ', $entry);
    $opponent = Symbol::tryFromCharacter(strtoupper($firstColumn));
    $me = Symbol::tryFromCharacter(strtoupper(str_replace(' ', '', $secondColumn)));

    $score += $winMatrix[$me->name][$opponent->name];
}

print_r($score.PHP_EOL);