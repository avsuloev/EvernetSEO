<?php

namespace App\Entity;

use App\Entity\Traits\GeneratedULIDTrait;
use App\Entity\Traits\JsonDataArrayTrait;
use App\Entity\Traits\TimestampableEntity;
use App\Repository\YMReportSourceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=YMReportSourceRepository::class)
 */
class YMReportSource
{
    use GeneratedULIDTrait;
    use TimestampableEntity;
    use JsonDataArrayTrait;
}
