<?php

declare(strict_types=1);

namespace PhpSerializers\Benchmarks\Bench;

use Doctrine\Common\Annotations\AnnotationReader;
use PhpSerializers\Benchmarks\AbstractBench;
use PhpSerializers\Benchmarks\Model\Forum;
use Symfony\Component\Cache\Adapter\ApcuAdapter;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\CacheClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class SymfonyObjectNormalizerBenchmark extends AbstractBench
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

        $propertyAccessor = PropertyAccess::createPropertyAccessorBuilder()
            ->setCacheItemPool(new ApcuAdapter('SymfonyPropertyAccessor'))
            ->getPropertyAccessor();

        $this->serializer = new Serializer(
            [new DateTimeNormalizer(), new ObjectNormalizer($classMetadataFactory, null, $propertyAccessor)],
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
