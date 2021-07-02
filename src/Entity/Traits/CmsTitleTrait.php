<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait CmsTitleTrait
{
    /**
     * Name for internal CMS usage.
     * Example: admin CRUD pages.
     *
     * @ORM\Column(type="text")
     */
    private string $cmsTitle;

    public function __toString(): string
    {
        return $this->cmsTitle ?? throw new \Error("Can't execute function __toString(): CMS title is NULL.");
    }

    public function getCmsTitle(): ?string
    {
        return $this->cmsTitle;
    }

    public function setCmsTitle(string $cmsTitle): self
    {
        $this->cmsTitle = $cmsTitle;

        return $this;
    }
}
