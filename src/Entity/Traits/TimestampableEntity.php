<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

trait TimestampableEntity
{
    /**
     * @var \DateTimeImmutable
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime_immutable")
     */
    protected $createdAt;

    /**
     * @var \DateTimeImmutable
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime_immutable")
     */
    protected $updatedAt;

    /**
     * Sets createdAt.
     *
     * @return $this
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Returns createdAt.
     *
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Sets updatedAt.
     *
     * @return $this
     */
    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Returns updatedAt.
     *
     * @return \DateTimeImmutable
     */
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
