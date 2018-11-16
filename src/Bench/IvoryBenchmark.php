<?php

declare(strict_types=1);

namespace PhpSerializers\Benchmarks\Bench;

use Ivory\Serializer\Mapping\Factory\CacheClassMetadataFactory;
use Ivory\Serializer\Mapping\Factory\ClassMetadataFactory;
use Ivory\Serializer\Navigator\Navigator;
use Ivory\Serializer\Registry\TypeRegistry;
use Ivory\Serializer\Serializer;
use Ivory\Serializer\Type\ObjectType;
use Ivory\Serializer\Type\Type;
use PhpSerializers\Benchmarks\AbstractBench;
use PhpSerializers\Benchmarks\Model\Forum;
use Symfony\Component\Cache\Adapter\ApcuAdapter;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class IvoryBenchmark extends AbstractBench
{
    /**
     * @var Serializer
     */
    private $serializer;

    public function initSerializer(): void
    {
        $classMetadataFactory = new CacheClassMetadataFactory(
            ClassMetadataFactory::create(),
            new ApcuAdapter('IvoryMetadata')
        );

        $typeRegistry = TypeRegistry::create([
            Type::OBJECT => new ObjectType($classMetadataFactory),
        ]);

        $this->serializer = new Serializer(new Navigator($typeRegistry));
    }

    public function serialize(Forum $data): void
    {
        $this->serializer->serialize($data, 'json');
    }
}
