<?php

namespace App\Entity\Etxt;

use App\Entity\Traits\CmsTitleTrait;
use App\Entity\Traits\GeneratedULIDTrait;
use App\Repository\Etxt\EtxtTaskTypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JetBrains\PhpStorm\ExpectedValues;

/**
 * @ORM\Entity(repositoryClass=EtxtTaskTypeRepository::class)
 *
 * @see https://www.etxt.ru/api/#tasks.saveTask Добавление/редактирование заказа.
 */
class EtxtTaskType
{
    use GeneratedULIDTrait;
    use TimestampableEntity;
    use CmsTitleTrait;

    /**
     * 'id_type' for Etxt API.
     * Идентификатор типа заказа, по умолчанию 1 (копирайтинг).
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $taskTypeId;

    /**
     * 'id_subtype' for Etxt API.
     * Тип текста, необязательный параметр (0 по умолчанию).
     * Значения:
     * 1 - продающий текст,
     * 2 - информационная статья,
     * 3 - новость/пресс-релиз,
     * 4 - текст для email-рассылки,
     * 5 - текст для соцсетей,
     * 6 - отзыв.
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $taskSubtypeId;

    /**
     * 'id_category' for Etxt API.
     * Идентификатор категории заказа, обязательное поле.
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $taskCategoryId;

    public function getTaskCategoryId(): ?int
    {
        return $this->taskCategoryId;
    }

    public function setTaskCategoryId(?int $taskCategoryId): self
    {
        $this->taskCategoryId = $taskCategoryId;

        return $this;
    }

    public function getTaskTypeId(): ?int
    {
        return $this->taskTypeId;
    }

    public function setTaskTypeId(?int $taskTypeId): self
    {
        $this->taskTypeId = $taskTypeId;

        return $this;
    }

    public function getTaskSubtypeId(): ?int
    {
        return $this->taskSubtypeId;
    }

    #[ExpectedValues(EtxtTaskOptions::TASK_SUBTYPE_ID)]
    public function setTaskSubtypeId(?int $taskSubtypeId): self
    {
        $this->taskSubtypeId = $taskSubtypeId;

        return $this;
    }
}
