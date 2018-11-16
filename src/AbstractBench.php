<?php

declare(strict_types=1);

namespace PhpSerializers\Benchmarks;

use PhpBench\Benchmark\Metadata\Annotations\Iterations;
use PhpSerializers\Benchmarks\Model\Forum;

/**
 * @BeforeMethods({"initSerializer", "initData"})
 * @Warmup(1)
 * @Revs(5)
 * @Iterations(5)
 */
abstract class AbstractBench
{
    /** @var DataProvider */
    private $dataProvider;
    /** @var Forum */
    private $data;

    public function __construct()
    {
        $this->dataProvider = new DataProvider();
    }

    final public function initData($params = [10, 10]): void
    {
        $this->data = $this->dataProvider->getData(...$params);
    }

    final public function benchSerialize(): void
    {
        $this->serialize($this->data);
    }

    abstract public function initSerializer(): void;

    abstract protected function serialize(Forum $data): void;
}