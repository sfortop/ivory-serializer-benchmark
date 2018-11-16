<?php

declare(strict_types=1);

namespace PhpSerializers\Benchmarks\Model;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
trait TimestampableTrait
{
    /**
     * @Ivory\Type("DateTimeImmutable")
     *
     * @var \DateTimeImmutable
     */
    private $createdAt;

    /**
     * @Ivory\Type("DateTime")
     *
     * @var \DateTime|null
     */
    private $updatedAt;

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeImmutable $createdAt
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    private function initializeTimestampable()
    {
        $this->createdAt = new \DateTimeImmutable();
    }
}
