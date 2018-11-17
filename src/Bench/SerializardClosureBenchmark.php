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
use Thunder\Serializard\NormalizerContainer\FallbackNormalizerContainer;
use Thunder\Serializard\Serializard;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
class SerializardClosureBenchmark extends AbstractBench
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
        $normalizers->add(Forum::class, function (Forum $forum) {
            return [
                'id' => $forum->getId(),
                'name' => $forum->getName(),
                'threads' => $forum->getThreads(),
                'category' => $forum->getCategory(),
                'createdAt' => $forum->getCreatedAt(),
                'updatedAt' => $forum->getUpdatedAt(),
            ];
        });
        $normalizers->add(Thread::class, function (Thread $thread) {
            return [
                'id' => $thread->getId(),
                'popularity' => $thread->getPopularity(),
                'title' => $thread->getTitle(),
                'comments' => $thread->getComments(),
                'description' => $thread->getDescription(),
                'createdAt' => $thread->getCreatedAt(),
                'updatedAt' => $thread->getUpdatedAt(),
            ];
        });
        $normalizers->add(Comment::class, function (Comment $comment) {
            return [
                'id' => $comment->getId(),
                'content' => $comment->getContent(),
                'author' => $comment->getAuthor(),
                'createdAt' => $comment->getCreatedAt(),
                'updatedAt' => $comment->getUpdatedAt(),
            ];
        });
        $normalizers->add(\DateTimeImmutable::class, function (\DateTimeImmutable $dt) {
            return $dt->format(\DATE_ATOM);
        });
        $normalizers->add(Category::class, function (Category $category) {
            return [
                'id' => $category->getId(),
                'parent' => $category->getParent(),
                'children' => $category->getChildren(),
                'createdAt' => $category->getCreatedAt(),
                'updatedAt' => $category->getUpdatedAt(),
            ];
        });

        $hydrators = new FallbackHydratorContainer();

        $this->serializer = new Serializard($formats, $normalizers, $hydrators);
    }

    public function serialize(Forum $data): void
    {
        $this->serializer->serialize($data, 'json');
    }

    public function getName(): string
    {
        return 'Serializard Closure';
    }

    public function getPackageName(): string
    {
        return 'thunderer/serializard';
    }
}
