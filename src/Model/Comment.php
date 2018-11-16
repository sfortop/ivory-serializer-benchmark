<?php

declare(strict_types=1);

namespace PhpSerializers\Benchmarks\Model;

use Ivory\Serializer\Mapping\Annotation as Ivory;
use JMS\Serializer\Annotation as Jms;
use TSantos\Serializer\Mapping as TSantos;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class Comment implements \JsonSerializable
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
    private $content;

    /**
     * @Ivory\Type("PhpSerializers\Benchmarks\Model\User")
     * @Jms\Type("PhpSerializers\Benchmarks\Model\User")
     * @TSantos\Type("PhpSerializers\Benchmarks\Model\User")
     *
     * @var User
     */
    private $author;

    /**
     * @param int $id
     * @param string $content
     * @param User|null $author
     */
    public function __construct(int $id, string $content, User $author = null)
    {
        $this->setId($id);
        $this->setContent($content);
        $this->setAuthor($author);
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
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * @return User|null
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * @param User|null $author
     */
    public function setAuthor(User $author = null)
    {
        $this->author = $author;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'author' => $this->author,
            'createdAt' => $this->createdAt instanceof \DateTimeInterface ? $this->createdAt->format(\DateTime::ATOM) : null,
            'updatedAt' => $this->updatedAt instanceof \DateTimeInterface ? $this->updatedAt->format(\DateTime::ATOM) : null,
        ];
    }
}
