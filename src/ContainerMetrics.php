<?php

namespace Acamposm\DockerEngineApiPoller;

class ContainerMetrics
{
    private object $metrics;

    /**
     * ContainerMetrics constructor.
     * @param object $container_stats
     */
    public function __construct(object $container_stats)
    {
        $this->metrics = $container_stats;
    }

    /**
     * Returns the available memory.
     *
     * @return int
     */
    private function getMemoryAvailable(): int
    {
        return property_exists($this->metrics->memory_stats, 'limit')
            ? $this->metrics->memory_stats->limit
            : 0;
    }

    /**
     * Returns the free memory available.
     *
     * @return int
     */
    private function getMemoryFree(): int
    {
        return self::getMemoryAvailable() - self::getMemoryUsed();
    }

    /**
     * Returns the used memory.
     *
     * @return int
     */
    private function getMemoryUsed(): int
    {
        $usage = property_exists($this->metrics->memory_stats, 'usage')
            ? $this->metrics->memory_stats->usage
            : 0;

        $cache = property_exists($this->metrics->memory_stats, 'stats')
            ? $this->metrics->memory_stats->stats->cache
            : 0;

        return $usage - $cache;
    }

    /**
     * Returns the percent memory available.
     *
     * @return float
     */
    private function getMemoryPercentFree(): float
    {
        return 100 - self::getMemoryPercentUsage();
    }

    /**
     * Returns the percent Memory used by the container.
     *
     * @return float
     */
    private function getMemoryPercentUsage(): float
    {
        if (self::getMemoryUsed() == 0 || self::getMemoryAvailable() == 0) {
            return 0;
        }

        return (self::getMemoryUsed() / self::getMemoryAvailable()) * 100.0;
    }


    private function getSystemCpuDelta(): float
    {
        $system_cpu_usage = property_exists($this->metrics->cpu_stats, 'system_cpu_usage')
            ? $this->metrics->cpu_stats->system_cpu_usage
            : 0;

        $precpu_system_cpu_usage = property_exists($this->metrics->precpu_stats, 'system_cpu_usage')
            ? $this->metrics->precpu_stats->system_cpu_usage
            : 0;

        return $system_cpu_usage - $precpu_system_cpu_usage;
    }

    /**
     * Return the number of cpus.
     *
     * @return int
     */
    private function getOnlineCpus(): int
    {
        return property_exists($this->metrics->cpu_stats, 'online_cpus')
            ? $this->metrics->cpu_stats->online_cpus
            : 0;
    }

    /**
     * @return float
     */
    private function getCpuDelta(): float
    {
        $cpu_total_usage = $this->metrics->cpu_stats->cpu_usage->total_usage;
        $precpu_total_usage = $this->metrics->precpu_stats->cpu_usage->total_usage;

        return $cpu_total_usage - $precpu_total_usage;
    }

    /**
     * Returns the CPU percent free.
     *
     * @return float
     */
    private function getCpuPercentFree(): float
    {
        return 100 - self::getCpuPercentUsage();
    }

    /**
     * Returns the percent CPU used by the container.
     *
     * @return float
     */
    private function getCpuPercentUsage(): float
    {
        if (self::getCpuDelta() === 0 || self::getSystemCpuDelta() === 0) {
            return 0;
        }

        return (self::getCpuDelta() / self::getSystemCpuDelta()) * self::getOnlineCpus() * 100.0;
    }

    /**
     * Returns an object with the basic metrics information.
     *
     * @return object
     */
    public function metrics(): object
    {
        if ($this->metrics->read === '0001-01-01T00:00:00Z') {
            return (object) [];
        }

        return (object) [
            'timestamp' => $this->metrics->read,
            'id' => $this->metrics->id,
            'name' => $this->metrics->name,
            'cpu' => (object) [
                'count' => self::getOnlineCpus(),
                'percent_free' => self::getCpuPercentFree(),
                'percent_used' => self::getCpuPercentUsage(),
            ],
            'memory' => (object) [
                'free' => self::getMemoryFree(),
                'used' => self::getMemoryUsed(),
                'total' => self::getMemoryAvailable(),
                'percent_free' => self::getMemoryPercentFree(),
                'percent_used' => self::getMemoryPercentUsage(),
            ],
            'network' => [
                property_exists($this->metrics, 'networks')
                    ? $this->metrics->networks
                    : [],
            ]
        ];
    }
}