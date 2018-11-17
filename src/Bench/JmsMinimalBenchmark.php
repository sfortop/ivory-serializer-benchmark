<?php

declare(strict_types=1);

namespace PhpSerializers\Benchmarks\Bench;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Cache\ApcuCache;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use Metadata\Cache\DoctrineCacheAdapter;
use PhpSerializers\Benchmarks\AbstractBench;
use PhpSerializers\Benchmarks\Model\Forum;

/**
 * @author Asmir Mustafic <goetas@gmail.com>
 */
class JmsMinimalBenchmark extends AbstractBench
{
    /**
     * @var Serializer
     */
    private $serializer;

    public function initSerializer(): void
    {
        $cache = new ApcuCache();
        $this->serializer = SerializerBuilder::create()
            ->setAnnotationReader(new CachedReader(new AnnotationReader(), $cache, false))
            ->setMetadataCache(new DoctrineCacheAdapter(__CLASS__, $cache))
            ->configureListeners(function () {
            })
            ->configureHandlers(function () {
            })
            ->build();
    }

    public function serialize(Forum $data): void
    {
        $this->serializer->serialize($data, 'json');
    }

    public function getName(): string
    {
        return 'JMS Minimal';
    }

    public function getPackageName(): string
    {
        return 'jms/serializer';
    }
}
