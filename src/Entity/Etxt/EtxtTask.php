<?php

namespace App\Entity\Etxt;

use App\Entity\Project;
use App\Entity\Traits\GeneratedULIDTrait;
use App\Repository\Etxt\EtxtTaskRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JetBrains\PhpStorm\ExpectedValues;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=EtxtTaskRepository::class)
 * @Vich\Uploadable
 *
 * @see https://www.etxt.ru/api/#tasks.saveTask Добавление/редактирование заказа.
 */
class EtxtTask
{
    use GeneratedULIDTrait;
    use TimestampableEntity;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="etxtTasks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    /**
     * @ORM\ManyToOne(targetEntity=EtxtAuthor::class, inversedBy="etxtTasks")
     */
    private $etxtAuthor;

    /**
     * 'file' for Etxt API.
     * Прилагаемый файл заказа.
     * NOTE: send to Etxt API as File.
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $taskFilename;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="taskFilename")
     */
    private File | null $taskFile;

    /**
     * 'id' for Etxt API.
     * Идентификатор редактируемого заказа,
     * если не указан, то заказ будет создан новый
     * (у ETXT при запросе API).
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $etxtId;

    /**
     * 'public' for Etxt API.
     * Флаг публикации заказа (0 - не публикуется, 1 - публикуется).
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $isPublicised;

    /**
     * 'title' for Etxt API.
     * Название заказа, не более 512 символов, обязательный параметр.
     *
     * @ORM\Column(type="text")
     */
    private string $title;

    /**
     * 'description' for Etxt API.
     * Описание заказа, не более 10000 символов.
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $taskDescription;

    /**
     * 'text' for Etxt API.
     * Текст заказа, не более 40000 символов.
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $taskText;

    /**
     * 'price' for Etxt API.
     * Цена заказа, обязательный параметр.
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $price;

    /**
     * 'price_type' for Etxt API.
     * Тип цены заказа (1 - за 1000 знаков, 2 - за весь заказ).
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $pricingMode;

    /**
     * 'deadline' for Etxt API.
     * Срок сдачи заказа в формате 'дд.мм.гггг', не более 90 дней.
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $deadlineDdMmYear;

    /**
     * 'timeline' for Etxt API.
     * Время сдачи заказа в формате 'чч:мм'.
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $deadlineHhMm;

    /**
     * 'id_folder' for Etxt API.
     * Идентификатор папки заказа.
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $taskFolderId;

    /**
     * 'keywords' for Etxt API.
     * Список ключевых слов через запятую для типа заказа SEO-копирайтинг (4).
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $keywords;

    /**
     * @ORM\ManyToOne(targetEntity=EtxtTaskTextRestraints::class)
     */
    private $textRestraints;

    /**
     * @ORM\ManyToOne(targetEntity=EtxtTasksAuthorRestraints::class)
     */
    private $authorRestraints;

    /**
     * @ORM\ManyToOne(targetEntity=EtxtTaskType::class)
     */
    private $taskType;

    /**
     * @ORM\ManyToOne(targetEntity=EtxtTasksAutoAccept::class)
     */
    private $autoacceptPolitic;

    /**
     * @ORM\ManyToOne(targetEntity=EtxtMultitasking::class)
     */
    private $multitaskingPolitic;

    // /**
    //  * 'language_from' for Etxt API.
    //  * Идентификатор языка, откуда осуществлять перевод, для типа заказа по переводу (3).
    //  *
    //  * @ORM\Column(type="integer", nullable=true)
    //  */
    // private ?int $languageFrom;

    // /**
    //  * 'language_to' for Etxt API.
    //  * Идентификатор языка, на который осуществлять перевод, для типа заказа по переводу (3).
    //  *
    //  * @ORM\Column(type="integer", nullable=true)
    //  */
    // private ?int $languageTo;

    public function __toString(): string
    {
        return $this->title;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function getEtxtAuthor(): ?EtxtAuthor
    {
        return $this->etxtAuthor;
    }

    public function setEtxtAuthor(?EtxtAuthor $etxtAuthor): self
    {
        $this->etxtAuthor = $etxtAuthor;

        return $this;
    }

    public function getTaskFilename(): ?string
    {
        return $this->taskFilename;
    }

    public function setTaskFilename(?string $taskFilename): self
    {
        $this->taskFilename = $taskFilename;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|UploadedFile|null $taskFile
     */
    public function setTaskFile(?File $taskFile = null): void
    {
        $this->taskFile = $taskFile;

        if (null !== $taskFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getTaskFile(): ?File
    {
        return $this->taskFile;
    }

    public function getEtxtId(): ?int
    {
        return $this->etxtId;
    }

    public function setEtxtId(?int $etxtId): self
    {
        $this->etxtId = $etxtId;

        return $this;
    }

    public function getIsPublicised(): ?int
    {
        return $this->isPublicised;
    }

    #[ExpectedValues(EtxtTaskOptions::SET_PUBLISHED_STATUS)]
    public function setIsPublicised(int $isPublicised): self
    {
        $this->isPublicised = $isPublicised;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTaskDescription(): ?string
    {
        return $this->taskDescription;
    }

    public function setTaskDescription(?string $taskDescription): self
    {
        $this->taskDescription = $taskDescription;

        return $this;
    }

    public function getTaskText(): ?string
    {
        return $this->taskText;
    }

    public function setTaskText(?string $taskText): self
    {
        $this->taskText = $taskText;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPricingMode(): ?int
    {
        return $this->pricingMode;
    }

    #[ExpectedValues(EtxtTaskOptions::SET_PRICING_MODE)]
    public function setPricingMode(int $pricingMode): self
    {
        $this->pricingMode = $pricingMode;

        return $this;
    }

    public function getDeadlineDdMmYear(): ?string
    {
        return $this->deadlineDdMmYear;
    }

    public function setDeadlineDdMmYear(?string $deadlineDdMmYear): self
    {
        $this->deadlineDdMmYear = $deadlineDdMmYear;

        return $this;
    }

    public function getDeadlineHhMm(): ?string
    {
        return $this->deadlineHhMm;
    }

    public function setDeadlineHhMm(?string $deadlineHhMm): self
    {
        $this->deadlineHhMm = $deadlineHhMm;

        return $this;
    }

    public function getTaskFolderId(): ?int
    {
        return $this->taskFolderId;
    }

    public function setTaskFolderId(?int $taskFolderId): self
    {
        $this->taskFolderId = $taskFolderId;

        return $this;
    }

    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    public function setKeywords(?string $keywords): self
    {
        $this->keywords = $keywords;

        return $this;
    }

    // public function getLanguageFrom(): ?int
    // {
    //     return $this->languageFrom;
    // }

    // public function setLanguageFrom(?int $languageFrom): self
    // {
    //     $this->languageFrom = $languageFrom;
    //
    //     return $this;
    // }

    // public function getLanguageTo(): ?int
    // {
    //     return $this->languageTo;
    // }

    // public function setLanguageTo(?int $languageTo): self
    // {
    //     $this->languageTo = $languageTo;
    //
    //     return $this;
    // }

    public function getTextRestraints(): ?EtxtTaskTextRestraints
    {
        return $this->textRestraints;
    }

    public function setTextRestraints(?EtxtTaskTextRestraints $textRestraints): self
    {
        $this->textRestraints = $textRestraints;

        return $this;
    }

    public function getAuthorRestraints(): ?EtxtTasksAuthorRestraints
    {
        return $this->authorRestraints;
    }

    public function setAuthorRestraints(?EtxtTasksAuthorRestraints $authorRestraints): self
    {
        $this->authorRestraints = $authorRestraints;

        return $this;
    }

    public function getTaskType(): ?EtxtTaskType
    {
        return $this->taskType;
    }

    public function setTaskType(?EtxtTaskType $taskType): self
    {
        $this->taskType = $taskType;

        return $this;
    }

    public function getAutoacceptPolitic(): ?EtxtTasksAutoAccept
    {
        return $this->autoacceptPolitic;
    }

    public function setAutoacceptPolitic(?EtxtTasksAutoAccept $autoacceptPolitic): self
    {
        $this->autoacceptPolitic = $autoacceptPolitic;

        return $this;
    }

    public function getMultitaskingPolitic(): ?EtxtMultitasking
    {
        return $this->multitaskingPolitic;
    }

    public function setMultitaskingPolitic(?EtxtMultitasking $multitaskingPolitic): self
    {
        $this->multitaskingPolitic = $multitaskingPolitic;

        return $this;
    }
}
