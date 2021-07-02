<?php

namespace App\Entity\Etxt;

use App\Entity\Traits\CmsTitleTrait;
use App\Entity\Traits\GeneratedULIDTrait;
use App\Repository\Etxt\EtxtTaskTextRestraintsRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * @ORM\Entity(repositoryClass=EtxtTaskTextRestraintsRepository::class)
 *
 * @see https://www.etxt.ru/api/#tasks.saveTask Добавление/редактирование заказа.
 */
class EtxtTaskTextRestraints
{
    use GeneratedULIDTrait;
    use TimestampableEntity;
    use CmsTitleTrait;

    /**
     * 'uniq' for Etxt API.
     * Требуемая уникальность заказа, по умолчанию не определена.
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $uniqueScore;

    /**
     * 'locate' for Etxt API.
     * Опция размещения текста на сайте, 1 - размещение нужно. 0 или нет. не нужно - по умолчанию.
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $placeOnSite;

    /**
     * 'whitespaces' for Etxt API.
     * Флаг с учетом пробелов или нет (0 - без пробелов, 1 - с пробелами).
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $spaceCountMode;

    /**
     * 'size' for Etxt API.
     * Размер заказа в символах, обязательный параметр при отсутствии параметра text.
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $taskSizeInChars;

    /**
     * 'checksize' for Etxt API.
     * Флаг учета минимального размера результата сдачи в 90%.
     * 1 - включено и тексты менее 90% от размера заказа приниматься не будут,
     * 0 - выключено.
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $require90PercentCompletion;

    public function getUniqueScore(): ?int
    {
        return $this->uniqueScore;
    }

    public function setUniqueScore(int $uniqueScore): self
    {
        $this->uniqueScore = $uniqueScore;

        return $this;
    }

    public function getPlaceOnSite(): ?int
    {
        return $this->placeOnSite;
    }

    #[ExpectedValues(EtxtTaskOptions::REQUIRE_PLACING_ON_SITE)]
    public function setPlaceOnSite(?int $placeOnSite): self
    {
        $this->placeOnSite = $placeOnSite;

        return $this;
    }

    public function getSpaceCountMode(): ?int
    {
        return $this->spaceCountMode;
    }

    #[ExpectedValues(EtxtTaskOptions::COUNT_WHITESPACES)]
    public function setSpaceCountMode(?int $spaceCountMode): self
    {
        $this->spaceCountMode = $spaceCountMode;

        return $this;
    }

    public function getTaskSizeInChars(): ?int
    {
        return $this->taskSizeInChars;
    }

    public function setTaskSizeInChars(?int $taskSizeInChars): self
    {
        $this->taskSizeInChars = $taskSizeInChars;

        return $this;
    }

    public function getRequire90PercentCompletion(): ?int
    {
        return $this->require90PercentCompletion;
    }

    #[ExpectedValues(EtxtTaskOptions::REQUIRE_90_PERCENT_COMPLETION)]
    public function setRequire90PercentCompletion(?int $require90PercentCompletion): self
    {
        $this->require90PercentCompletion = $require90PercentCompletion;

        return $this;
    }
}
