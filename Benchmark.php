<?php

class Benchmark
{
    public float $timeStart;
    public int $memoryStart;
    public int $memoryPeakStart;

    public function start(): self
    {
        $this->timeStart = microtime(true);
        $this->memoryStart = memory_get_usage();
        $this->memoryPeakStart = memory_get_peak_usage();

        return $this;
    }

    public function getExecutionTime(): string
    {
        return number_format(microtime(true) - $this->timeStart, 3);
    }

    public function getMemoryUsed(): string
    {
        return round((memory_get_usage() - $this->memoryStart) / 1024) . "KB of memory";
    }

    public function getPeakMemoryUsed(): string
    {
        return round((memory_get_peak_usage() - $this->memoryPeakStart) / 1024) . "KB of memory";
    }

    public static function printMem(): void
    {
        /* Currently used memory */
        $mem_usage = memory_get_usage();

        /* Peak memory usage */
        $mem_peak = memory_get_peak_usage();

        echo "The script is now using: " . round($mem_usage / 1024) . "KB of memory.\n";
        echo "Peak usage: " . round($mem_peak / 1024) . "KB of memory.\n\n";
    }

    public function getRenderInfo(): array
    {
        $result = [];
        $result['sysinfo']['time'] = date('Y-m-d H:i:s T');
        $result['sysinfo']['php_version'] = PHP_VERSION;
        $result['sysinfo']['platform'] = PHP_OS;
        $result['sysinfo']['server_name'] = $_SERVER['SERVER_NAME'] ?? null;
        $result['sysinfo']['server_addr'] = $_SERVER['SERVER_ADDR'] ?? null;
        $result['sysinfo']['xdebug'] = in_array('xdebug', get_loaded_extensions(), true) === true ? 'ON' : 'OFF';

        return $result;
    }
}
