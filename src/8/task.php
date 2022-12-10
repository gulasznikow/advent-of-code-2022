<?php

$data = file(__DIR__ . '/input.txt');
function isInvisible($x, $y, $data): array
{
    $tree = $data[$y][$x];
    print_r('tree ' . $x . '-' . $y . ' ' . $data[$y][$x] . PHP_EOL);
    $visibleFromTop = true;
    $visibleFromBottom = true;
    $visibleFromLeft = true;
    $visibleFromRight = true;
    $amountVisibleFromTop = 0;
    $amountVisibleFromBottom = 0;
    $amountVisibleFromLeft = 0;
    $amountVisibleFromRight = 0;
    for ($toLeft = $x - 1; $toLeft >= 0; $toLeft--) {
        if ($toLeft !== $x && $data[$y][$toLeft] >= $tree) {
            $visibleFromLeft = false;
            print_r($x . '-' . $y . ' not visible from left' . PHP_EOL);
            print_r($data[$y][$toLeft] . ' blocks' . PHP_EOL);
            break;
        }
        $amountVisibleFromLeft++;
    }

    for ($toRight = $x + 1; $toRight < strlen(rtrim($data[0])); $toRight++) {
        if ($toRight !== $x && $data[$y][$toRight] >= $tree) {
            $visibleFromRight = false;
            print_r($x . '-' . $y . ' not visible from right' . PHP_EOL);
            print_r($data[$y][$toRight] . ' blocks' . PHP_EOL);
            break;
        }
        $amountVisibleFromRight++;
    }

    for ($toUp = $y - 1; $toUp >= 0; $toUp--) {
        if ($toUp !== $y && $data[$toUp][$x] >= $tree) {
            $visibleFromTop = false;
            print_r($x . '-' . $y . ' not visible from top' . PHP_EOL);
            print_r($data[$toUp][$x] . ' blocks' . PHP_EOL);
            break;
        }
        $amountVisibleFromTop++;
    }

    for ($toBottom = $y + 1; $toBottom < count($data); $toBottom++) {
        if ($toBottom !== $y && $data[$toBottom][$x] >= $tree) {
            $visibleFromBottom = false;
            print_r($x . '-' . $y . ' not visible from bottom' . PHP_EOL);
            print_r($data[$toBottom][$x] . ' blocks' . PHP_EOL);
            break;
        }
        $amountVisibleFromBottom++;
    }
    $isInvisible =
        $visibleFromLeft == false
        && $visibleFromRight == false
        && $visibleFromTop == false
        && $visibleFromBottom == false;
    return [
        'invisible' => $isInvisible,
        'score' => $visibleFromLeft * $visibleFromBottom * $visibleFromTop * $visibleFromRight
    ];
}

$visibleTrees = 0;
print_r('GRID ' . count($data) . ' ' . strlen(rtrim($data[0])));
print_r(PHP_EOL);
//die();
$scores = [];
for ($i = 1; $i < strlen(rtrim($data[0])) - 1; $i++) {
    for ($j = 1; $j < count($data) - 1; $j++) {
//        if (!isInvisible($i, $j, $data)['invisible']) {
//            print_r($i . '-' . $j . ' IS VISIBLE' . PHP_EOL);
//            $visibleTrees++;
//            continue;
//        }
        $scores[] = isInvisible($i, $j, $data)['score'];
    }
}
print_r('VISIBLE INNER = ' . $visibleTrees . PHP_EOL);
print_r('VISIBLE EDGES = ' . ((2 * count($data)) + (2 * strlen(rtrim($data[0]))) - 4) . PHP_EOL);
print_r($visibleTrees + (2 * count($data)) + (2 * strlen(rtrim($data[0]))) - 4);

print_r($scores);