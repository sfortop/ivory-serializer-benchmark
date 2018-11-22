<?php

declare(strict_types=1);

namespace PhpSerializers\Benchmarks\Bench;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Cache\ApcuCache;
use Metadata\Cache\PsrCacheAdapter;
use PhpSerializers\Benchmarks\AbstractBench;
use PhpSerializers\Benchmarks\Model\Forum;
use Symfony\Component\Cache\Adapter\ApcuAdapter;
use TSantos\Serializer\Metadata\Driver\AnnotationDriver;
use TSantos\Serializer\SerializerBuilder;

/**
 * @author Tales Santos <tales.augusto.santos@gmail.com>
 */
class TSantosBenchmark extends AbstractBench
{
    /**
     * @var \TSantos\Serializer\Serializer
     */
    private $serializer;

    public function initSerializer(): void
    {
        if (!file_exists($cache = __DIR__. '/../../cache/hydrators')) {
            mkdir($cache);
        }

        $this->serializer = (new SerializerBuilder())
            ->setMetadataDriver(new AnnotationDriver(new AnnotationReader(), new ApcuCache(), false))
            ->setHydratorDir($cache)
            ->setMetadataCache(new PsrCacheAdapter('TSantosMetadata', new ApcuAdapter()))
            ->enableBuiltInNormalizers()
            ->setDebug(false)
            ->build();
    }

    public function serialize(Forum $data): void
    {
        $this->serializer->serialize($data);
    }

    public function getPackageName(): string
    {
        return 'tsantos/serializer';
    }

    public function getNote(): string
    {
        return <<<'NOTE'
Serializes an object graphs using generated data extractor for each class
NOTE;

    }


}
