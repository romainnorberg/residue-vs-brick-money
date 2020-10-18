<?php

const ITERATOR = 20000;
require('vendor/autoload.php');
require('Benchmark.php');

use Brick\Money\Context\CashContext;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;
use Romainnorberg\Residue\Residue;
use Brick\Money\Money;

$output = new ConsoleOutput();
$input = new class extends Symfony\Component\Console\Input\Input {
    protected function parse()
    {
    }

    public function getFirstArgument()
    {
    }

    public function hasParameterOption($values, bool $onlyParams = false)
    {
    }

    public function getParameterOption($values, $default = false, bool $onlyParams = false)
    {
    }
};

$logger = new ConsoleLogger($output);
$io = new SymfonyStyle($input, $output);
$io->title('Benchmark romainnorberg/residue vs brick/money');

$benchmark = new Benchmark();
$tableResult = [];


/* ***** */

$io->section('Host info');

$renderInfo = $benchmark->getRenderInfo();
$io->table(['Param', 'Value'],
    [
        ['time', $renderInfo['sysinfo']['time']],
        ['php_version', $renderInfo['sysinfo']['php_version']],
        ['platform', $renderInfo['sysinfo']['platform']],
        ['server_name', $renderInfo['sysinfo']['server_name']],
        ['server_addr', $renderInfo['sysinfo']['server_addr']],
        ['xdebug', $renderInfo['sysinfo']['xdebug']],
        ['iterator', ITERATOR],
    ]);

/**
 * Instantiation
 */

$benchmark->start();
new Residue(100);
$tableResult['romainnorberg_residue'] = [
    'execution_time'   => $benchmark->getExecutionTime(),
    'memory_used'      => $benchmark->getMemoryUsed(),
    'peak_memory_used' => $benchmark->getPeakMemoryUsed(),
];

$benchmark->start();
Money::of(100, 'USD');
$tableResult['brick_money'] = [
    'execution_time'   => $benchmark->getExecutionTime(),
    'memory_used'      => $benchmark->getMemoryUsed(),
    'peak_memory_used' => $benchmark->getPeakMemoryUsed(),
];

$io->section('Instantiation');

$io->table(
    [
        'Package',
        'Execution time (sec)',
        'Memory used',
        'Peak memory used',
    ],
    [
        [
            'romainnorberg/residue',
            $tableResult['romainnorberg_residue']['execution_time'],
            $tableResult['romainnorberg_residue']['memory_used'],
            $tableResult['romainnorberg_residue']['peak_memory_used'],
        ],
        [
            'brick/money',
            $tableResult['brick_money']['execution_time'],
            $tableResult['brick_money']['memory_used'],
            $tableResult['brick_money']['peak_memory_used'],
        ],
    ]);

/**
 * Basic split
 */

$benchmark->start();
for ($i = 0; $i < ITERATOR; ++$i) {
    $residue = Residue::create(100)->divideBy(3); // 33.34, 33.33, 33.33

    foreach ($residue->split() as $part) {
        $partValue = $part;
        //var_dump($partValue);
    }
}
$tableResult['romainnorberg_residue'] = [
    'execution_time'   => $benchmark->getExecutionTime(),
    'memory_used'      => $benchmark->getMemoryUsed(),
    'peak_memory_used' => $benchmark->getPeakMemoryUsed(),
];

$benchmark->start();
for ($i = 0; $i < ITERATOR; ++$i) {
    $money = Money::of(100, 'USD'); // USD 33.34, USD 33.33, USD 33.33

    foreach ($money->split(3) as $part) {
        $partValue = $part->getAmount()->toFloat();
    }
}
$tableResult['brick_money'] = [
    'execution_time'   => $benchmark->getExecutionTime(),
    'memory_used'      => $benchmark->getMemoryUsed(),
    'peak_memory_used' => $benchmark->getPeakMemoryUsed(),
];

$io->section('Basic split');
$io->block('e.g. 100/3 = [33.34, 33.33, 33.33]');

$io->table(
    [
        'Package',
        'Execution time (sec)',
        'Memory used',
        'Peak memory used',
    ],
    [
        [
            'romainnorberg/residue',
            $tableResult['romainnorberg_residue']['execution_time'],
            $tableResult['romainnorberg_residue']['memory_used'],
            $tableResult['romainnorberg_residue']['peak_memory_used'],
        ],
        [
            'brick/money',
            $tableResult['brick_money']['execution_time'],
            $tableResult['brick_money']['memory_used'],
            $tableResult['brick_money']['peak_memory_used'],
        ],
    ]);

/**
 * Rounding (step)
 */

$benchmark->start();
for ($i = 0; $i < ITERATOR; ++$i) {
    $residue = Residue::create(100)
        ->divideBy(3)
        ->step(0.05); // 33.35, 33.35, 33.30

    foreach ($residue->split() as $part) {
        $partValue = $part;
        //var_dump($partValue);
    }
}
$tableResult['romainnorberg_residue'] = [
    'execution_time'   => $benchmark->getExecutionTime(),
    'memory_used'      => $benchmark->getMemoryUsed(),
    'peak_memory_used' => $benchmark->getPeakMemoryUsed(),
];

$benchmark->start();
for ($i = 0; $i < ITERATOR; ++$i) {
    $money = Money::of(100, 'USD', new CashContext(5)); // USD 33.35, USD 33.35, USD 33.30

    foreach ($money->split(3) as $part) {
        $partValue = $part->getAmount()->toFloat();
        //var_dump($partValue);
    }
}
$tableResult['brick_money'] = [
    'execution_time'   => $benchmark->getExecutionTime(),
    'memory_used'      => $benchmark->getMemoryUsed(),
    'peak_memory_used' => $benchmark->getPeakMemoryUsed(),
];

$io->section('Rounding/step split');
$io->block('e.g. 100/3 (with 0.05 step) = [33.35, 33.35, 33.30]');

$io->table(
    [
        'Package',
        'Execution time (sec)',
        'Memory used',
        'Peak memory used',
    ],
    [
        [
            'romainnorberg/residue',
            $tableResult['romainnorberg_residue']['execution_time'],
            $tableResult['romainnorberg_residue']['memory_used'],
            $tableResult['romainnorberg_residue']['peak_memory_used'],
        ],
        [
            'brick/money',
            $tableResult['brick_money']['execution_time'],
            $tableResult['brick_money']['memory_used'],
            $tableResult['brick_money']['peak_memory_used'],
        ],
    ]);
