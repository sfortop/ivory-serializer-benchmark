<?php

namespace PhpSerializers\Benchmarks;

use PackageVersions\Versions;
use PhpBench\Benchmark\Metadata\BenchmarkMetadata;

/**
 * Class BenchFinder
 *
 * @author Tales Santos <tales.augusto.santos@gmail.com>
 */
class BenchFinder
{
    const DEFAULT_VERSION = 'N/A';

    /**
     * @var \PhpBench\Benchmark\BenchmarkFinder
     */
    private $internalFinder;

    /**
     * @var string
     */
    private $path;

    /**
     * BenchmarkFinder constructor.
     * @param \PhpBench\Benchmark\BenchmarkFinder $internalFinder
     * @param string $path
     */
    public function __construct(\PhpBench\Benchmark\BenchmarkFinder $internalFinder, string $path)
    {
        $this->internalFinder = $internalFinder;
        $this->path = $path;
    }

    public function findAll(): array
    {
        $benchmarks = [];

        /** @var BenchmarkMetadata $metadata */
        foreach ($this->internalFinder->findBenchmarks($this->path) as $metadata) {
            $data = $this->createBenchData($metadata);
            $benchmarks[$data['package']][] = $this->createBenchData($metadata);
        }

        return $benchmarks;
    }

    public function findOne(string $name): array
    {
        $benchmarksFound = $this->internalFinder->findBenchmarks($this->path, [$name]);

        if (empty($benchmarksFound)) {
            throw new \InvalidArgumentException('There is no benchmark with name "' . $name . '"');
        }

        $bench = current($benchmarksFound);

        return $this->createBenchData($bench);
    }

    private function createBenchData(BenchmarkMetadata $metadata): array
    {
        $ref = new \ReflectionClass($metadata->getClass());

        $bench = $ref->newInstance();

        try {
            $versionParts = explode('@', Versions::getVersion($bench->getPackageName()));
            $version = $versionParts[0];
        } catch (\OutOfBoundsException $boundsException) {
            $version = self::DEFAULT_VERSION;
        }

        return [
            'bench' => $bench,
            'name' => $ref->getShortName(),
            'package' => $bench->getPackageName(),
            'version' => $version,
            'note' => $bench->getNote()
        ];
    }
}
