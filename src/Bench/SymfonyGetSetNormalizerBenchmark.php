<?php

declare(strict_types=1);

namespace PhpSerializers\Benchmarks\Bench;

use Doctrine\Common\Annotations\AnnotationReader;
use PhpSerializers\Benchmarks\AbstractBench;
use PhpSerializers\Benchmarks\Model\Forum;
use Symfony\Component\Cache\Adapter\ApcuAdapter;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\CacheClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class SymfonyGetSetNormalizerBenchmark extends AbstractBench
{
    /**
     * @var Serializer
     */
    private $serializer;

    public function initSerializer(): void
    {
        $classMetadataFactory = new CacheClassMetadataFactory(
            new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader())),
            new ApcuAdapter('SymfonyMetadata')
        );

        $this->serializer = new Serializer(
            [new DateTimeNormalizer(), new GetSetMethodNormalizer($classMetadataFactory)],
            [new JsonEncoder()]
        );
    }

    public function serialize(Forum $data): void
    {
        $this->serializer->serialize($data, 'json');
    }

    public function getPackageName(): string
    {
        return 'symfony/serializer';
    }
}
