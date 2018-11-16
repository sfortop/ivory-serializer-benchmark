<?php

declare(strict_types=1);

namespace PhpSerializers\Benchmarks\Model;

use Ivory\Serializer\Mapping\Annotation as Ivory;
use JMS\Serializer\Annotation as Jms;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class Forum implements \JsonSerializable
{
    use TimestampableTrait;

    /**
     * @Ivory\Type("int")
     * @Jms\Type("integer")
     *
     * @var int
     */
    private $id;

    /**
     * @Ivory\Type("string")
     * @Jms\Type("string")
     *
     * @var string
     */
    private $name;

    /**
     * @Ivory\Type("PhpSerializers\Benchmarks\Model\Category")
     * @Jms\Type("PhpSerializers\Benchmarks\Model\Category")
     *
     * @var Category
     */
    private $category;

    /**
     * @Ivory\Type("array<key=int, value=PhpSerializers\Benchmarks\Model\Thread>")
     * @Jms\Type("array<integer, PhpSerializers\Benchmarks\Model\Thread>")
     *
     * @var Thread[]
     */
    private $threads;

    /**
     * @param int $id
     * @param string $name
     * @param Category|null $category
     * @param Thread[] $threads
     */
    public function __construct(int $id, string $name, Category $category = null, array $threads = [])
    {
        $this->setId($id);
        $this->setName($name);
        $this->setThreads($threads);
        $this->initializeTimestampable();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category|null $category
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;
    }

    /**
     * @return Thread[]
     */
    public function getThreads(): array
    {
        return $this->threads;
    }

    /**
     * @param Thread[] $threads
     */
    public function setThreads(array $threads)
    {
        $this->threads = $threads;
    }

    /**
     * @param Thread $thread
     */
    public function addThread(Thread $thread)
    {
        $this->threads[] = $thread;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category,
            'threads' => $this->threads,
            'createdAt' => $this->createdAt instanceof \DateTimeInterface ? $this->createdAt->format(\DateTime::ATOM) : null,
            'updatedAt' => $this->updatedAt instanceof \DateTimeInterface ? $this->updatedAt->format(\DateTime::ATOM) : null,
        ];
    }
}
