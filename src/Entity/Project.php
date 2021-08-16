<?php

namespace App\Entity;

use App\Entity\Etxt\EtxtTask;
use App\Entity\Traits\CmsTitleTrait;
use App\Entity\Traits\GeneratedULIDTrait;
use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    use GeneratedULIDTrait;
    use TimestampableEntity;
    use CmsTitleTrait;

    /**
     * TopVisor identifier.
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $tvId;

    /**
     * YandexMetrika identifier.
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $ymId;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isActive = true;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="projects", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Client $client;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $url;

    /**
     * @ORM\OneToMany(targetEntity=KeywordGroup::class, mappedBy="project", orphanRemoval=true, cascade={"persist", "remove"}, fetch="EXTRA_LAZY")
     */
    private Collection $keywordGroups;

    /**
     * @ORM\OneToMany(targetEntity=EtxtTask::class, mappedBy="project")
     */
    private $etxtTasks;

    public function __construct()
    {
        $this->keywordGroups = new ArrayCollection();
        $this->etxtTasks = new ArrayCollection();
    }

    public function getTvId(): ?string
    {
        return $this->tvId;
    }

    public function setTvId(?string $tvId): self
    {
        $this->tvId = $tvId;

        return $this;
    }

    public function getYmId(): ?string
    {
        return $this->ymId;
    }

    public function setYmId(?string $ymId): self
    {
        $this->ymId = $ymId;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

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

    /**
     * @return Collection|KeywordGroup[]
     */
    public function getKeywordGroups(): Collection
    {
        return $this->keywordGroups;
    }

    public function addKeywordGroup(KeywordGroup $keywordGroup): self
    {
        if (!$this->keywordGroups->contains($keywordGroup)) {
            $this->keywordGroups[] = $keywordGroup;
            $keywordGroup->setProject($this);
        }

        return $this;
    }

    public function removeKeywordGroup(KeywordGroup $keywordGroup): self
    {
        if ($this->keywordGroups->removeElement($keywordGroup)) {
            // set the owning side to null (unless already changed)
            if ($keywordGroup->getProject() === $this) {
                $keywordGroup->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EtxtTask[]
     */
    public function getEtxtTasks(): Collection
    {
        return $this->etxtTasks;
    }

    public function addEtxtTask(EtxtTask $etxtTask): self
    {
        if (!$this->etxtTasks->contains($etxtTask)) {
            $this->etxtTasks[] = $etxtTask;
            $etxtTask->setProject($this);
        }

        return $this;
    }

    public function removeEtxtTask(EtxtTask $etxtTask): self
    {
        if ($this->etxtTasks->removeElement($etxtTask)) {
            // set the owning side to null (unless already changed)
            if ($etxtTask->getProject() === $this) {
                $etxtTask->setProject(null);
            }
        }

        return $this;
    }
}
