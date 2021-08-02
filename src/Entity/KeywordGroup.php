<?php

namespace App\Entity;

use App\Entity\Traits\GeneratedULIDTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Gedmo\Tree\Traits\NestedSetEntityUuid;

/**
 * @Gedmo\Tree(type="nested")
 * @ORM\Entity(repositoryClass=NestedTreeRepository::class)
 */
class KeywordGroup
{
    use GeneratedULIDTrait;
    use TimestampableEntity;
    use NestedSetEntityUuid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="keywordGroups")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Project $project;

    /**
     * @ORM\OneToMany(targetEntity=Keyword::class, mappedBy="keywordGroup", orphanRemoval=true)
     */
    private $keywords;

//    /**
//     * @ORM\Column(type="boolean")
//     */
//    private bool $isExcludedAsSub = false;

    /**
     * Used to store the tree root id value
     * or identify the column as the relation to root node.
     *
     * @Gedmo\TreeRoot
     * @ORM\ManyToOne(targetEntity=KeywordGroup::class)
     * @ORM\JoinColumn(name="tree_root", referencedColumnName="id", onDelete="CASCADE")
     */
    private $root;

    /**
     * Relation to parent node.
     *
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity=KeywordGroup::class, inversedBy="subgroups")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $supergroup;

    /**
     * @ORM\OneToMany(targetEntity=KeywordGroup::class, mappedBy="supergroup")
     * @ORM\OrderBy({"left" = "ASC"})
     */
    private $subgroups;

    public function __construct()
    {
        $this->keywords = new ArrayCollection();
        $this->subgroups = new ArrayCollection();
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

    public function getRoot(): ?self
    {
        return $this->root;
    }

//    public function setRoot(?self $root): self
//    {
//        $this->root = $root;
//
//        return $this;
//    }

    public function getSupergroup(): ?self
    {
        return $this->supergroup;
    }

    public function setSupergroup(?self $supergroup): self
    {
        $this->supergroup = $supergroup;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getSubgroups(): Collection
    {
        return $this->subgroups;
    }

//    public function addSubgroup(self $subgroup): self
//    {
//        if (!$this->subgroups->contains($subgroup)) {
//            $this->subgroups[] = $subgroup;
//            $subgroup->setSupergroup($this);
//        }
//
//        return $this;
//    }
//
//    public function removeSubgroup(self $subgroup): self
//    {
//        if ($this->subgroups->removeElement($subgroup)) {
//            // set the owning side to null (unless already changed)
//            if ($subgroup->getSupergroup() === $this) {
//                $subgroup->setSupergroup(null);
//            }
//        }
//
//        return $this;
//    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getRight(): ?int
    {
        return $this->right;
    }

    public function setRight(int $right): self
    {
        $this->right = $right;

        return $this;
    }

    public function getLeft(): ?int
    {
        return $this->left;
    }

    public function setLeft(int $left): self
    {
        $this->left = $left;

        return $this;
    }

//    public function getIsExcludedAsSub(): ?bool
//    {
//        return $this->isExcludedAsSub;
//    }
//
//    public function setIsExcludedAsSub(bool $isExcludedAsSub): self
//    {
//        $this->isExcludedAsSub = $isExcludedAsSub;
//
//        return $this;
//    }
}
