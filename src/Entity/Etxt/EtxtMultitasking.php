<?php

namespace App\Entity\Etxt;

use App\Entity\Traits\CmsTitleTrait;
use App\Entity\Traits\GeneratedULIDTrait;
use App\Repository\Etxt\EtxtMultitaskingRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * @ORM\Entity(repositoryClass=EtxtMultitaskingRepository::class)
 *
 * @see https://www.etxt.ru/api/#tasks.saveTask Добавление/редактирование заказа.
 */
class EtxtMultitasking
{
    use GeneratedULIDTrait;
    use TimestampableEntity;
    use CmsTitleTrait;

    /**
     * 'multione' for Etxt API.
     * 1 - если поставить ограничение "один мультизаказ одному исполнителю",
     * 0 - без ограничения (по умолчанию).
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $multitoneMode;

    /**
     * 'multitask' for Etxt API.
     * Флаг мультизаказа (1 - мультизаказ, 0 - обычный).
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $isMultitask;

    /**
     * 'multicount' for Etxt API.
     * Число мультизаказов.
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $multitasksCounted;

    public function getMultitoneMode(): ?int
    {
        return $this->multitoneMode;
    }

    #[ExpectedValues(EtxtTaskOptions::SET_MULTITASK_WORK_MODE)]
    public function setMultitoneMode(?int $multitoneMode): self
    {
        $this->multitoneMode = $multitoneMode;

        return $this;
    }

    public function getIsMultitask(): ?int
    {
        return $this->isMultitask;
    }

    #[ExpectedValues(EtxtTaskOptions::SET_MULTITASK)]
    public function setIsMultitask(?int $isMultitask): self
    {
        $this->isMultitask = $isMultitask;

        return $this;
    }

    public function getMultitasksCounted(): ?int
    {
        return $this->multitasksCounted;
    }

    public function setMultitasksCounted(?int $multitasksCounted): self
    {
        $this->multitasksCounted = $multitasksCounted;

        return $this;
    }
}
