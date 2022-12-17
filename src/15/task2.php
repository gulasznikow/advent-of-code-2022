<?php
$starttime = microtime(true);
require '../../vendor/autoload.php';

$data = file(__DIR__ . '/input.txt');

$beacons = [];
$sensors = [];
$map = [];

$minX = 0;
$maxX = 0;
foreach ($data as $row) {
    $parsedRow = str_replace(['Sensor at ', ' closest beacon is at '], '', trim($row));
    $coords = explode(':', $parsedRow);
    [$sensorX, $sensorY] = explode(', ', $coords[0]);
    [$beaconX, $beaconY] = explode(', ', $coords[1]);
    $sensorX = substr($sensorX, 2);
    $sensorY = substr($sensorY, 2);
    $beaconX = substr($beaconX, 2);
    $beaconY = substr($beaconY, 2);
    $sensors[$sensorX . '-' . $sensorY] = [
        'sx' => (float)$sensorX,
        'sy' => (float)$sensorY,
        'bx' => (float)$beaconX,
        'by' => (float)$beaconY
    ];
    $beacons[$beaconX . '-' . $beaconY] = 0;
}

$diamonds = [];

foreach ($sensors as $sensor) {
    $diamonds [] = new Diamond(
        $sensor['sx'],
        $sensor['sy'],
        $sensor['bx'],
        $sensor['by']
    );
}


class Diamond
{
    public int $width = 0;
    public int $height = 0;

    public function __construct(
        public int $sx,
        public int $sy,
        public int $bx,
        public int $by
    )
    {
        $this->width = abs($sx - $bx) + abs($sy - $by);
        $this->height = $this->width;

    }

    public function contains($x, $y): bool
    {
        $dx = abs($x - $this->sx);
        $dy = abs($y - $this->sy);

        $d = $dx + $dy;
        return $d <= $this->width;
    }

    public static function doesNotContainAnywhere($x, $y, $diamonds): bool
    {
        /** @var Diamond $diamond */
        foreach ($diamonds as $diamond) {
            $dx = abs($x - $diamond->sx);
            $dy = abs($y - $diamond->sy);

            $d = $dx + $dy;
            if ($d <= $diamond->width) return false;
        }

        return true;
    }
}

$boundaries = 4000000;
//$boundaries = 20;
//11756174628223
foreach ($diamonds as $diamond) {
    for ($i = 0; $i <= $diamond->width + 1; $i++) {
        foreach (
            [
                [$diamond->sx + $i, $diamond->sy + ($diamond->width+1 - $i)],
                [$diamond->sx - $i, $diamond->sy + ($diamond->width+1 - $i)],
                [$diamond->sx + $i, $diamond->sy - ($diamond->width+1 - $i)],
                [$diamond->sx - $i, $diamond->sy - ($diamond->width+1 - $i)]
            ] as $direction
        ) {
            if ($direction[0] < 0 || $direction[1] < 0 || $direction[0] > $boundaries || $direction[1] > $boundaries) {
                continue;
            };
            if (Diamond::doesNotContainAnywhere($direction[0], $direction[1], $diamonds)) {
                print_r('RESULT ' . ($direction[0] * 4000000 + $direction[1]) . PHP_EOL);
                $endtime = microtime(true);
                print_r(($endtime - $starttime).' s'.PHP_EOL);
                die();
            }
        };
    }
}

print_r('DONE');