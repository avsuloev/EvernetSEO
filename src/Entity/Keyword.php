<?php

namespace App\Entity;

use App\Entity\Traits\GeneratedULIDTrait;
use App\Repository\KeywordRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=KeywordRepository::class)
 */
class Keyword
{
    use GeneratedULIDTrait;
    use TimestampableEntity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $url;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isApproved = false;

    /**
     * @ORM\ManyToOne(targetEntity=KeywordGroup::class, inversedBy="keywords")
     */
    private ?KeywordGroup $keywordGroup;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $position;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $frequency;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $clientNote;

    public function __toString()
    {
        return $this->name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getIsApproved(): ?bool
    {
        return $this->isApproved;
    }

    public function setIsApproved(bool $isApproved): self
    {
        $this->isApproved = $isApproved;

        return $this;
    }

    public function getKeywordGroup(): ?KeywordGroup
    {
        return $this->keywordGroup;
    }

    public function setKeywordGroup(?KeywordGroup $keywordGroup): self
    {
        $this->keywordGroup = $keywordGroup;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getFrequency(): ?int
    {
        return $this->frequency;
    }

    public function setFrequency(?int $frequency): self
    {
        $this->frequency = $frequency;

        return $this;
    }

    public function getClientNote(): ?string
    {
        return $this->clientNote;
    }

    public function setClientNote(?string $clientNote): self
    {
        $this->clientNote = $clientNote;

        return $this;
    }
}
