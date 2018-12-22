<?php

namespace Ivory\Tests\Serializer\Benchmark;

use BetterSerializer\Builder;
use BetterSerializer\Common\SerializationType;
use BetterSerializer\Serializer;
use PhpSerializers\Benchmarks\AbstractBench;
use PhpSerializers\Benchmarks\Model\Forum;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class BetterSerializerBenchmark extends AbstractBench
{

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * {@inheritdoc}
     */
    public function initSerializer(): void
    {
        $builder = new Builder();

        if (extension_loaded('apcu') && ini_get('apc.enabled')) {
            $builder->enableApcuCache();
        } else {
            $builder->enableFilesystemCache(dirname(__DIR__, 1) . '/cache/better-serializer');
        }

        $this->serializer = $builder->createSerializer();
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(Forum $data): void
    {
        $this->serializer->serialize(
            $data,
            SerializationType::JSON()
        );
    }

    public function getPackageName(): string
    {
        return 'better-serializer/better-serializer';
    }

    public function getNote(): string
    {
        return <<<'NOTE'
Serializer for PHP 7.2+ supporting JSON
NOTE;
    }
}
