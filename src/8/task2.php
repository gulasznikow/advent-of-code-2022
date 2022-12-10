<?php

$data = file(__DIR__ . '/input.txt');
function isInvisible($x, $y, $data): int
{
    $tree = $data[$y][$x];
    print_r('tree ' . $x . '-' . $y . ' ' . $data[$y][$x] . PHP_EOL);
    $amountVisibleFromTop = 0;
    $amountVisibleFromBottom = 0;
    $amountVisibleFromLeft = 0;
    $amountVisibleFromRight = 0;
    for ($toLeft = $x - 1; $toLeft >= 0; $toLeft--) {
        $amountVisibleFromLeft++;
        if ($toLeft !== $x && $data[$y][$toLeft] >= $tree) {
            break;
        }
    }

    for ($toRight = $x + 1; $toRight < strlen(rtrim($data[0])); $toRight++) {
        $amountVisibleFromRight++;
        if ($toRight !== $x && $data[$y][$toRight] >= $tree) {
            break;
        }
    }

    for ($toUp = $y - 1; $toUp >= 0; $toUp--) {
        $amountVisibleFromTop++;
        if ($toUp !== $y && $data[$toUp][$x] >= $tree) {
            break;
        }
    }

    for ($toBottom = $y + 1; $toBottom < count($data); $toBottom++) {
        $amountVisibleFromBottom++;
        if ($toBottom !== $y && $data[$toBottom][$x] >= $tree) {
            break;
        }
    }
    print_r($amountVisibleFromLeft .' * '. $amountVisibleFromRight .' * '. $amountVisibleFromTop .' * '. $amountVisibleFromBottom.PHP_EOL);
    return $amountVisibleFromLeft * $amountVisibleFromRight * $amountVisibleFromTop * $amountVisibleFromBottom;
}

$visibleTrees = 0;

$scores = [];
for ($i = 1; $i < strlen(rtrim($data[0])) - 1; $i++) {
    for ($j = 1; $j < count($data) - 1; $j++) {
        $scores[] = isInvisible($i, $j, $data);
    }
}

print_r(PHP_EOL.max($scores));