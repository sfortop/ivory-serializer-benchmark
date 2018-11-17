<?php

declare(strict_types=1);

namespace PhpSerializers\Benchmarks\Model;

use Ivory\Serializer\Mapping\Annotation as Ivory;
use JMS\Serializer\Annotation as Jms;
use TSantos\Serializer\Mapping as TSantos;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class Thread implements \JsonSerializable
{
    use TimestampableTrait;

    /**
     * @Ivory\Type("int")
     * @Jms\Type("integer")
     * @TSantos\Type("integer")
     *
     * @var int
     */
    private $id;

    /**
     * @Ivory\Type("string")
     * @Jms\Type("string")
     * @TSantos\Type("string")
     *
     * @var string
     */
    private $title;

    /**
     * @Ivory\Type("string")
     * @Jms\Type("string")
     * @TSantos\Type("string")
     *
     * @var string
     */
    private $description;

    /**
     * @Ivory\Type("float")
     * @Jms\Type("float")
     * @TSantos\Type("float")
     *
     * @var float
     */
    private $popularity;

    /**
     * @Ivory\Type("array<key=int, value=PhpSerializers\Benchmarks\Model\Comment>")
     * @Jms\Type("array<integer, PhpSerializers\Benchmarks\Model\Comment>")
     * @TSantos\Type("PhpSerializers\Benchmarks\Model\Comment[]")
     *
     * @var Comment[]
     */
    private $comments;

    /**
     * @param int $id
     * @param string $title
     * @param string $description
     * @param float $popularity
     * @param Comment[] $comments
     */
    public function __construct(int $id, string $title, string $description, float $popularity, array $comments = [])
    {
        $this->setId($id);
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setPopularity($popularity);
        $this->setComments($comments);
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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return float
     */
    public function getPopularity(): float
    {
        return $this->popularity;
    }

    /**
     * @param float $popularity
     */
    public function setPopularity(float $popularity)
    {
        $this->popularity = $popularity;
    }

    /**
     * @return Comment[]
     */
    public function getComments(): array
    {
        return $this->comments;
    }

    /**
     * @param Comment[] $comments
     */
    public function setComments(array $comments)
    {
        $this->comments = $comments;
    }

    /**
     * @param Comment $comment
     */
    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'popularity' => $this->popularity,
            'comments' => $this->comments,
            'createdAt' => $this->createdAt instanceof \DateTimeInterface ? $this->createdAt->format(\DateTime::ATOM) : null,
            'updatedAt' => $this->updatedAt instanceof \DateTimeInterface ? $this->updatedAt->format(\DateTime::ATOM) : null,
        ];
    }
}
