<?php

require '../../vendor/autoload.php';

$data = file(__DIR__ . '/input.txt');

$beacons = [];
$sensors = [];
$map = [];

$minX = 0;
$maxX = 0;
foreach ($data as $row)
{
    $parsedRow = str_replace(['Sensor at ',' closest beacon is at '],'', trim($row));
    $coords = explode(':', $parsedRow);
    [$sensorX, $sensorY] = explode(', ',$coords[0]);
    [$beaconX, $beaconY] = explode(', ',$coords[1]);
    $sensorX = substr($sensorX,2);
    $sensorY = substr($sensorY,2);
    $beaconX = substr($beaconX,2);
    $beaconY = substr($beaconY,2);
    $minX = min($minX, $sensorX, $beaconX);
    $maxX = max($maxX, $sensorX, $beaconX);
    $sensors[$sensorX.'-'.$sensorY] = [
        'sx' => (int)$sensorX,
        'sy' => (int)$sensorY,
        'bx' => (int)$beaconX,
        'by' => (int)$beaconY
    ];
    $beacons[$beaconX.'-'.$beaconY] = 0;
}

$diamonds = [];

foreach ($sensors as $sensor)
{
    $diamonds [] = new Diamond(
        $sensor['sx'],
        $sensor['sy'],
        $sensor['bx'],
        $sensor['by']
    );
}

$maxWidth = max(array_map(function (Diamond $d){return $d->width;}, $diamonds));

$minX -= $maxWidth;
$maxX += $maxWidth;

$amount = 0;
$targetY = 2000000;
foreach (range($minX,$maxX) as $step)
{
    $validPlace = true;
    foreach ($diamonds as $diamond)
    {
        if ($diamond->contains($step, $targetY))
        {
            $validPlace= false;
            break;
        }
    }
    if (!$validPlace && !isset($beacons[$step.'-'.$targetY])) $amount++;
}

print_r($amount);

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
        $this->width = abs($sx-$bx) + abs($sy-$by);
        $this->height = $this->width;

    }

    public function contains($x, $y): bool
    {
        $dx = abs($x - $this->sx);
        $dy = abs($y - $this->sy);

        $d = ($dx/$this->width) + ($dy/$this->height);
        return $d<=1;
    }
}