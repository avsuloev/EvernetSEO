<?php

namespace App\Entity;

use App\Entity\Traits\GeneratedULIDTrait;
use App\Entity\Traits\JsonDataArrayTrait;
use App\Entity\Traits\TimestampableEntity;
use App\Repository\YMReportVisitsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=YMReportVisitsRepository::class)
 */
class YMReportVisits
{
    use GeneratedULIDTrait;
    use TimestampableEntity;
    use JsonDataArrayTrait;

    /**
     * @ORM\Column(type="json")
     */
    private $jsonData = [];

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $visits;

    public function getJsonData(): ?array
    {
        return $this->jsonData;
    }

    public function setJsonData(array $jsonData): self
    {
        $this->jsonData = $jsonData;

        return $this;
    }

    public function getVisits(): ?int
    {
        return $this->visits;
    }

    public function setVisits(?int $visits): self
    {
        $this->visits = $visits;

        return $this;
    }
}
