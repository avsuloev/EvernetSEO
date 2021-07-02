<?php

namespace App\Entity\Etxt;

use App\Entity\Traits\CmsTitleTrait;
use App\Entity\Traits\GeneratedULIDTrait;
use App\Repository\Etxt\EtxtTasksAuthorRestraintsRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * @ORM\Entity(repositoryClass=EtxtTasksAuthorRestraintsRepository::class)
 *
 * @see https://www.etxt.ru/api/#tasks.saveTask Добавление/редактирование заказа.
 */
class EtxtTasksAuthorRestraints
{
    use GeneratedULIDTrait;
    use TimestampableEntity;
    use CmsTitleTrait;

    /**
     * 'only_stars' for Etxt API.
     * Флаг учета уровня мастерства исполнителя (0 - без учета, 1 - с учетом).
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $requireSkillCheck;

    /**
     * 'target_task' for Etxt API.
     * Флаг доступности заказа
     * (1 - для всех, 2 - для белого списка, 3 - индивидуальный заказ).
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $whitelistMode;

    /**
     * 'id_target' for Etxt API.
     * Идентификатор пользователя, для кого выставлен индивидуальный заказ,
     * или группы БС - если заказ выставляется для конкретной группы.
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $whitelistId;

    /**
     * 'bwgroup_send' for Etxt API.
     * Флаг (1 - посылать, 0 или не указан - не посылать), посылать ли уведомление группе из БС
     * о выставлении для них заказа (параметры target_task = 2, id_target = ИД группы БС).
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $notifyWhitelisted;

    /**
     * 'attestat' for Etxt API.
     * Флаг заказа только для аттестованных по теме копирайтеров
     * (1 - копирайтеры прошли тест на знание тематики и имеют
     * профессиональное образование (Доступно для четырех тематических категорий:
     * 1. Медицина. 2. Строительство. 3. Закон и право. 4. Бухгалтерия и финансы),
     * 0 или не указан - нет).
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $isCertifiedOnly;

    /**
     * 'diplom' for Etxt API.
     * Флаг заказа только для дипломированных копирайтеров
     * (1 - исполнители загрузили и подтвердили свой диплом,
     * специализация которого указана в профиле,
     * 0 или не указан - нет ).
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $isGraduatedOnly;

    public function getRequireSkillCheck(): ?int
    {
        return $this->requireSkillCheck;
    }

    #[ExpectedValues(EtxtTaskOptions::REQUIRE_SKILL_CHECK)]
    public function setRequireSkillCheck(?int $requireSkillCheck): self
    {
        $this->requireSkillCheck = $requireSkillCheck;

        return $this;
    }

    public function getWhitelistMode(): ?int
    {
        return $this->whitelistMode;
    }

    #[ExpectedValues(EtxtTaskOptions::SET_WHITELIST_MODE)]
    public function setWhitelistMode(?int $whitelistMode): self
    {
        $this->whitelistMode = $whitelistMode;

        return $this;
    }

    public function getWhitelistId(): ?int
    {
        return $this->whitelistId;
    }

    public function setWhitelistId(?int $whitelistId): self
    {
        $this->whitelistId = $whitelistId;

        return $this;
    }

    public function getNotifyWhitelisted(): ?int
    {
        return $this->notifyWhitelisted;
    }

    #[ExpectedValues(EtxtTaskOptions::REQUIRE_NOTIFICATION_FOR_AUTHORS)]
    public function setNotifyWhitelisted(?int $notifyWhitelisted): self
    {
        $this->notifyWhitelisted = $notifyWhitelisted;

        return $this;
    }

    public function getIsCertifiedOnly(): ?int
    {
        return $this->isCertifiedOnly;
    }

    #[ExpectedValues(EtxtTaskOptions::REQUIRE_CERTIFIED_ONLY)]
    public function setIsCertifiedOnly(?int $isCertifiedOnly): self
    {
        $this->isCertifiedOnly = $isCertifiedOnly;

        return $this;
    }

    public function getIsGraduatedOnly(): ?int
    {
        return $this->isGraduatedOnly;
    }

    #[ExpectedValues(EtxtTaskOptions::REQUIRE_GRADUATED_ONLY)]
    public function setIsGraduatedOnly(?int $isGraduatedOnly): self
    {
        $this->isGraduatedOnly = $isGraduatedOnly;

        return $this;
    }
}
