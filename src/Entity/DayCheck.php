<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DayCheckRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=DayCheckRepository::class)
 * @ApiResource(
 *  normalizationContext={
 *      "groups"={"dayChecks_read"}
 * }
 * )
 */
class DayCheck
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"dayChecks_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     * @Groups({"dayChecks_read", "residents_read"})
     * @Assert\NotBlank(message="Le nom de de la journée est obligatoire")
     * @Assert\Length(min=3, minMessage="Le nom doit faire entre 3 et 255 caractères",
     *      max=255, maxMessage="Le nom doit faire entre 3 et 255 caractères")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=80)
     * @Groups({"dayChecks_read", "residents_read"})
     * @Assert\NotBlank(message="Le choix doit etre renseigné")
     * @Assert\Choice(choices={"matin/midi/soir", "matin/midi", "matin/soir", "midi/soir", "matin", "midi", "soir"},
     *     message="Le choix doit etre matin/midi/soir, matin/midi, matin/soir, midi/soir, matin, midi, soir")
     */
    private $checkTime;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"dayChecks_read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"dayChecks_read"})
     */
    private $updateAt;



    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"dayChecks_read"})
     * @Assert\NotBlank(message="Le nom de de la semaine est obligatoire")
     * @Assert\Length(min=3, minMessage="Le nom doit faire entre 3 et 255 caractères",
     *      max=255, maxMessage="Le nom doit faire entre 3 et 255 caractères")
     */
    private $week;

    /**
     * @ORM\ManyToOne(targetEntity=Resident::class, inversedBy="dayChecks")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"dayChecks_read"})
     */
    private $resident;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="dayChecks")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"dayChecks_read"})
     */
    private $createdBy;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCheckTime(): ?string
    {
        return $this->checkTime;
    }

    public function setCheckTime(string $checkTime): self
    {
        $this->checkTime = $checkTime;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }



    public function getWeek(): ?string
    {
        return $this->week;
    }

    public function setWeek(string $week): self
    {
        $this->week = $week;

        return $this;
    }

    public function getResident(): ?Resident
    {
        return $this->resident;
    }

    public function setResident(?Resident $resident): self
    {
        $this->resident = $resident;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }
}
