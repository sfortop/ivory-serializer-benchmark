<?php

declare(strict_types=1);

namespace PhpSerializers\Benchmarks\Bench;

use PhpSerializers\Benchmarks\AbstractBench;

/**
 * @author scyzoryck <scyzoryck@gmail.com>
 */
class JsonSerializableBenchmark extends AbstractBench
{
    public function initSerializer(): void
    {

    }

    public function serialize($data): void
    {
        json_encode(
            $data
        );
    }
}
