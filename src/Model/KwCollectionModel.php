<?php

namespace App\Model;

use App\Entity\Keyword;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JetBrains\PhpStorm\Pure;

class KwCollectionModel
{
    /**
     * @var Collection|Keyword[]
     */
    private $keywords;

    #[Pure]
    public function __construct()
    {
        $this->keywords = new ArrayCollection();
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
        }

        return $this;
    }

    public function removeKeyword(Keyword $keyword): self
    {
        $this->keywords->removeElement($keyword);

        return $this;
    }
}
