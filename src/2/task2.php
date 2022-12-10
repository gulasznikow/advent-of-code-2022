<?php
namespace Task\RockPaperScissors\PartTwo;

enum Symbol: int
{
    case ROCK = 1;
    case PAPER = 2;
    case SCISSORS = 3;

    case LOSE = 4;
    case DRAW = 5;
    case WIN = 6;

    public static function tryFromCharacter(string $symbol): Symbol
    {
        return match (true){
            str_contains($symbol,'A') => self::ROCK,
            str_contains($symbol,'B') => self::PAPER,
            str_contains($symbol,'C') => self::SCISSORS,
            str_contains($symbol,'X') => self::LOSE,
            str_contains($symbol,'Y') => self::DRAW,
            str_contains($symbol,'Z') => self::WIN,
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

$resultMatrix = [
    Symbol::LOSE->name => [
        Symbol::PAPER->name => Symbol::ROCK,
        Symbol::ROCK->name => Symbol::SCISSORS,
        Symbol::SCISSORS->name => Symbol::PAPER,
    ],
    Symbol::DRAW->name => [
        Symbol::PAPER->name => Symbol::PAPER,
        Symbol::ROCK->name => Symbol::ROCK,
        Symbol::SCISSORS->name => Symbol::SCISSORS,
    ],
    Symbol::WIN->name => [
        Symbol::PAPER->name => Symbol::SCISSORS,
        Symbol::ROCK->name => Symbol::PAPER,
        Symbol::SCISSORS->name => Symbol::ROCK,
    ],
];
$data = file(__DIR__ . '/input.txt');
$score = 0;

foreach ($data as $entry)
{
    [$firstColumn, $secondColumn] = explode(' ', $entry);
    $opponent = Symbol::tryFromCharacter(strtoupper($firstColumn));
    $me = Symbol::tryFromCharacter(strtoupper(str_replace(' ', '', $secondColumn)));

    $expectedResult = $resultMatrix[$me->name][$opponent->name];

    $score += $winMatrix[$expectedResult->name][$opponent->name];
}

print_r($score.PHP_EOL);