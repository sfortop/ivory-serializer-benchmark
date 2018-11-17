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

    final public function initData(array $params): void
    {
        $this->data = $this->dataProvider->getData(...$params);
    }

    /**
     * @ParamProviders("provideComplexity")
     */
    final public function benchSerialize(): void
    {
        $this->serialize($this->data);
    }

    public function provideComplexity(): array
    {
        return [
            [10, 10],
            [1, 60],
            [60, 1],
            [60, 60],
        ];
    }

    abstract public function initSerializer(): void;

    abstract protected function serialize(Forum $data): void;

    abstract public function getName(): string;

    abstract public function getPackageName(): ?string;
}
