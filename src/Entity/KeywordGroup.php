<?php

namespace App\Entity;

use App\Entity\Traits\GeneratedULIDTrait;
use App\Repository\KeywordGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=KeywordGroupRepository::class)
 */
class KeywordGroup
{
    use GeneratedULIDTrait;
    use TimestampableEntity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="keywordGroups")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    /**
     * @ORM\OneToMany(targetEntity=Keyword::class, mappedBy="keywordGroup", orphanRemoval=true)
     */
    private $keywords;

    /**
     * @ORM\ManyToMany(targetEntity=KeywordGroup::class, inversedBy="supergroups")
     * @ORM\JoinTable(name="linked_key_groups",
     *     joinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="linked_group_id", referencedColumnName="id")}
     * )
     */
    private $subgroups;

    /**
     * @ORM\ManyToMany(targetEntity=KeywordGroup::class, mappedBy="subgroups")
     */
    private $supergroups;

    public function __construct()
    {
        $this->keywords = new ArrayCollection();
        $this->subgroups = new ArrayCollection();
        $this->supergroups = new ArrayCollection();
    }

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

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @return Collection|Keyword[]
     */
    public function getKeywords(): Collection
    {
        return $this->keywords;
    }

    public function addKeyword(Keyword $keyword): self
    {
        if (!$this->keywords->contains($keyword)) {
            $this->keywords[] = $keyword;
            $keyword->setKeywordGroup($this);
        }

        return $this;
    }

    public function removeKeyword(Keyword $keyword): self
    {
        if ($this->keywords->removeElement($keyword)) {
            // set the owning side to null (unless already changed)
            if ($keyword->getKeywordGroup() === $this) {
                $keyword->setKeywordGroup(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getSubgroups(): Collection
    {
        return $this->subgroups;
    }

    public function addSubgroup(self $subgroup): self
    {
        if (!$this->subgroups->contains($subgroup)) {
            $this->subgroups[] = $subgroup;
        }

        return $this;
    }

    public function removeSubgroup(self $subgroup): self
    {
        $this->subgroups->removeElement($subgroup);

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getSupergroups(): Collection
    {
        return $this->supergroups;
    }

    public function addSupergroup(self $supergroup): self
    {
        if (!$this->supergroups->contains($supergroup)) {
            $this->supergroups[] = $supergroup;
            $supergroup->addSubgroup($this);
        }

        return $this;
    }

    public function removeSupergroup(self $supergroup): self
    {
        if ($this->supergroups->removeElement($supergroup)) {
            $supergroup->removeSubgroup($this);
        }

        return $this;
    }
}
