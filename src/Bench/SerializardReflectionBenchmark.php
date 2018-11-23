<?php

declare(strict_types=1);

namespace PhpSerializers\Benchmarks\Bench;

use PhpSerializers\Benchmarks\AbstractBench;
use PhpSerializers\Benchmarks\Model\Category;
use PhpSerializers\Benchmarks\Model\Comment;
use PhpSerializers\Benchmarks\Model\Forum;
use PhpSerializers\Benchmarks\Model\Thread;
use Thunder\Serializard\Format\JsonFormat;
use Thunder\Serializard\FormatContainer\FormatContainer;
use Thunder\Serializard\HydratorContainer\FallbackHydratorContainer;
use Thunder\Serializard\Normalizer\ReflectionNormalizer;
use Thunder\Serializard\NormalizerContainer\FallbackNormalizerContainer;
use Thunder\Serializard\Serializard;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
class SerializardReflectionBenchmark extends AbstractBench
{
    /**
     * @var Serializard
     */
    private $serializer;

    public function initSerializer(): void
    {
        $formats = new FormatContainer();
        $formats->add('json', new JsonFormat());

        $normalizers = new FallbackNormalizerContainer();
        $normalizers->add(Forum::class, new ReflectionNormalizer());
        $normalizers->add(Thread::class, new ReflectionNormalizer());
        $normalizers->add(Comment::class, new ReflectionNormalizer());
        $normalizers->add(Category::class, new ReflectionNormalizer());
        $normalizers->add(\DateTimeImmutable::class, function (\DateTimeImmutable $dt) {
            return $dt->format(\DATE_ATOM);
        });

        $hydrators = new FallbackHydratorContainer();

        $this->serializer = new Serializard($formats, $normalizers, $hydrators);
    }

    public function serialize(Forum $data): void
    {
        $this->serializer->serialize($data, 'json');
    }

    public function getPackageName(): string
    {
        return 'thunderer/serializard';
    }

    public function getNote(): string
    {
        return <<<'NOTE'
Serialize object graphs extracting its value through property reflection
NOTE;
    }
}
