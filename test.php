<?php

require('vendor/autoload.php');

use Romainnorberg\Residue\Residue;

/*
$residue = Residue::create(7.315)
    ->divideBy(3)
    ->decimal(2)
    ->step(0.05);

var_dump($residue->toArray()); // [2.45, 2.45, 2.40]
var_dump($residue->getRemainder()); // -> 0.015

///

$residue = Residue::create(7.315)
    ->divideBy(3)
    ->decimal(2)
    ->step(0.05);

var_dump($residue->toArray(Residue::SPLIT_MODE_EQUITY)); // [2.40, 2.40, 2.40]
var_dump($residue->getRemainder()); // -> 0.115


$residue = Residue::create(100)
    ->divideBy(3)
    ->decimal(0);

var_dump([iterator_to_array($residue->split()), $residue->getRemainder()]);

$r = Residue::create(101)
    ->divideBy(3)
    ->decimal(0);

var_dump(iterator_to_array($r->split(Residue::SPLIT_MODE_EQUITY))); // -> [33, 33, 33]
var_dump($r->getRemainder()); // 2
*/

var_dump(Residue::create(100)->divideBy(3)->toArray());
