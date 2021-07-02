<?php

namespace App\Entity\Etxt;

use App\Entity\Traits\GeneratedULIDTrait;
use App\Repository\Etxt\EtxtAuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=EtxtAuthorRepository::class)
 *
 * @see https://www.etxt.ru/api/#users.getList Список исполнителей.
 */
class EtxtAuthor
{
    use GeneratedULIDTrait;
    use TimestampableEntity;

    /**
     * 'id_user' for Etxt API.
     * Идентификатор пользователя.
     *
     * @ORM\Column(type="integer")
     */
    private int $etxtId;

    /**
     * 'login' for Etxt API.
     * Логин пользователя.
     *
     * @ORM\Column(type="string", length=255)
     */
    private string $login;

    /**
     * 'fio' for Etxt API.
     * ФИО пользователя.
     *
     * @ORM\Column(type="string", length=255)
     */
    private string $fullName;

    /**
     * 'description' for Etxt API.
     * Дополнительная информация о пользователе.
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * 'country' for Etxt API.
     * Страна пользователя.
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $country;

    /**
     * 'city' for Etxt API.
     * Город пользователя.
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $city;

    /**
     * 'regdate' for Etxt API.
     * Дата регистрации пользователя (unixtime у Etxt API).
     *
     * @ORM\Column(type="datetime_immutable")
     */
    private $etxtRegisteredAt;

    /**
     * 'rate' for Etxt API.
     * Рейтинг пользователя.
     *
     * @ORM\Column(type="integer")
     */
    private $rating;

    /**
     * @ORM\OneToMany(targetEntity=EtxtTask::class, mappedBy="etxtAuthor")
     */
    private $etxtTasks;

    public function __construct()
    {
        $this->etxtTasks = new ArrayCollection();
    }

    public function getEtxtId(): ?int
    {
        return $this->etxtId;
    }

    public function setEtxtId(int $etxtId): self
    {
        $this->etxtId = $etxtId;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getEtxtRegisteredAt(): ?\DateTimeImmutable
    {
        return $this->etxtRegisteredAt;
    }

    public function setEtxtRegisteredAt(\DateTimeImmutable $etxtRegisteredAt): self
    {
        $this->etxtRegisteredAt = $etxtRegisteredAt;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * @return Collection|EtxtTask[]
     */
    public function getEtxtTasks(): Collection
    {
        return $this->etxtTasks;
    }

    public function addEtxtTask(EtxtTask $etxtTask): self
    {
        if (!$this->etxtTasks->contains($etxtTask)) {
            $this->etxtTasks[] = $etxtTask;
            $etxtTask->setEtxtAuthor($this);
        }

        return $this;
    }

    public function removeEtxtTask(EtxtTask $etxtTask): self
    {
        if ($this->etxtTasks->removeElement($etxtTask)) {
            // set the owning side to null (unless already changed)
            if ($etxtTask->getEtxtAuthor() === $this) {
                $etxtTask->setEtxtAuthor(null);
            }
        }

        return $this;
    }
}
