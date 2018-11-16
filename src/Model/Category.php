<?php

declare(strict_types=1);

namespace PhpSerializers\Benchmarks\Model;

use Ivory\Serializer\Mapping\Annotation as Ivory;
use JMS\Serializer\Annotation as Jms;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class Category implements \JsonSerializable
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
     * @Ivory\Type("PhpSerializers\Benchmarks\Model\Category")
     * @Jms\Type("PhpSerializers\Benchmarks\Model\Category")
     *
     * @var Category|null
     */
    private $parent;

    /**
     * @Ivory\Type("array<key=int, value=PhpSerializers\Benchmarks\Model\Category>")
     * @Jms\Type("array<integer, PhpSerializers\Benchmarks\Model\Category>")
     *
     * @var Category[]
     */
    private $children = [];

    /**
     * @param int $id
     * @param Category|null $parent
     * @param Category[] $children
     */
    public function __construct(int $id, Category $parent = null, array $children = [])
    {
        $this->setId($id);
        $this->setParent($parent);
        $this->setChildren($children);
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
     * @return Category|null
     */
    public function getParent(): ?Category
    {
        return $this->parent;
    }

    /**
     * @param Category|null $parent
     */
    public function setParent(Category $parent = null)
    {
        $this->parent = $parent;
    }

    /**
     * @return Category[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @param Category[] $children
     */
    public function setChildren(array $children)
    {
        $this->children = $children;
    }

    /**
     * @param Category $child
     */
    public function addChild(Category $child)
    {
        $this->children[] = $child;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'parent' => $this->parent,
            'children' => $this->children,
            'createdAt' => $this->createdAt instanceof \DateTimeInterface ? $this->createdAt->format(\DateTime::ATOM) : null,
            'updatedAt' => $this->updatedAt instanceof \DateTimeInterface ? $this->updatedAt->format(\DateTime::ATOM) : null,
        ];
    }
}
