<?php

namespace App\Entity\Etxt;

use App\Entity\Traits\CmsTitleTrait;
use App\Entity\Traits\GeneratedULIDTrait;
use App\Repository\Etxt\EtxtTasksAutoAcceptRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * @ORM\Entity(repositoryClass=EtxtTasksAutoAcceptRepository::class)
 *
 * @see https://www.etxt.ru/api/#tasks.saveTask Добавление/редактирование заказа.
 */
class EtxtTasksAutoAccept
{
    use GeneratedULIDTrait;
    use TimestampableEntity;
    use CmsTitleTrait;

    /**
     * 'auto_work' for Etxt API.
     * Флаг автопринятия заявки в заказе
     * (1 - автопринятие, 0 - нет).
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $autoAccept;

    /**
     * 'auto_rate' for Etxt API.
     * Рейтинг для автопринятия заказа, по умолчанию 0.
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $autoAcceptMinRating;

    /**
     * 'auto_reports' for Etxt API.
     * Число положительных отзывов для автопринятия заказа (не менее),
     * 0 по умолчанию.
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $autoAcceptMinPositiveReviews;

    /**
     * 'auto_reports_n' for Etxt API.
     * Число отрицательных отзывов для автопринятия заказа (не более),
     * по умолчанию параметр отсутствует, может быть 0.
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $autoAcceptMaxNegativeReviews;

    /**
     * 'auto_level' for Etxt API.
     * Идентификатор уровня мастерства исполнителя для автопринятия заказа,
     * по умолчанию 0 (без квалификации).
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $autoAcceptAllowedSkillLvl;

    public function getAutoAccept(): ?int
    {
        return $this->autoAccept;
    }

    #[ExpectedValues(EtxtTaskOptions::AUTOACCEPT_DEAL)]
    public function setAutoAccept(?int $autoAccept): self
    {
        $this->autoAccept = $autoAccept;

        return $this;
    }

    public function getAutoAcceptMinRating(): ?int
    {
        return $this->autoAcceptMinRating;
    }

    public function setAutoAcceptMinRating(?int $autoAcceptMinRating): self
    {
        $this->autoAcceptMinRating = $autoAcceptMinRating;

        return $this;
    }

    public function getAutoAcceptMinPositiveReviews(): ?int
    {
        return $this->autoAcceptMinPositiveReviews;
    }

    public function setAutoAcceptMinPositiveReviews(?int $autoAcceptMinPositiveReviews): self
    {
        $this->autoAcceptMinPositiveReviews = $autoAcceptMinPositiveReviews;

        return $this;
    }

    public function getAutoAcceptMaxNegativeReviews(): ?int
    {
        return $this->autoAcceptMaxNegativeReviews;
    }

    public function setAutoAcceptMaxNegativeReviews(?int $autoAcceptMaxNegativeReviews): self
    {
        $this->autoAcceptMaxNegativeReviews = $autoAcceptMaxNegativeReviews;

        return $this;
    }

    public function getAutoAcceptAllowedSkillLvl(): ?int
    {
        return $this->autoAcceptAllowedSkillLvl;
    }

    public function setAutoAcceptAllowedSkillLvl(?int $autoAcceptAllowedSkillLvl): self
    {
        $this->autoAcceptAllowedSkillLvl = $autoAcceptAllowedSkillLvl;

        return $this;
    }
}
