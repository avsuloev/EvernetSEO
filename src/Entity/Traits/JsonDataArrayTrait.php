<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait JsonDataArrayTrait
{
    /**
     * @ORM\Column(type="json")
     */
    private $jsonData = [];

    public function getJsonData(): ?array
    {
        return $this->jsonData;
    }

    public function setJsonData(array $jsonData): self
    {
        $this->jsonData = $jsonData;

        return $this;
    }
}
