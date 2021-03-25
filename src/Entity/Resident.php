<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\ResidentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ResidentRepository::class)
 * @ApiResource(
 *  normalizationContext={
 *      "groups"={"residents_read"}
 * }
 * )
 */
class Resident
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"residents_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"residents_read", "unities_read", "diets_read", "textures_read"})
     * @Assert\NotBlank(message="Le prénom du Résident est obligatoire")
     * @Assert\Length(min=3, minMessage="Le prénom doit faire entre 3 et 255 caractères",
     *      max=255, maxMessage="Le prénom doit faire entre 3 et 255 caractères")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"residents_read", "unities_read", "diets_read", "textures_read"})
     * @Assert\NotBlank(message="Le nom du Résident est obligatoire")
     * @Assert\Length(min=3, minMessage="Le nom doit faire entre 3 et 255 caractères",
     *     max=255, maxMessage="Le nom doit faire entre 3 et 255 caractères")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"residents_read", "unities_read", "diets_read", "textures_read"})
     * @Assert\NotBlank(message="le numéro de sa chambre est obligatoire")
     */
    private $room;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"residents_read"})
     * @Assert\NotBlank(message="date de naissance  obligatoire")
     */
    private $bornAt;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"residents_read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"residents_read"})
     */
    private $updateAt;


    /**
     * @ORM\ManyToOne(targetEntity=Unity::class, inversedBy="residents")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"residents_read"})
     * @Assert\NotBlank(message="emplacement d'unité  obligatoire")
     */
    private $unity;

    /**
     * @ORM\ManyToMany(targetEntity=Diet::class, mappedBy="resident")
     * @Groups({"residents_read"})
     */
    private $diets;

    /**
     * @ORM\ManyToMany(targetEntity=Texture::class, mappedBy="resident")
     * @Groups({"residents_read"})
     */
    private $textures;

    /**
     * @ORM\OneToMany(targetEntity=DayCheck::class, mappedBy="resident", orphanRemoval=true)
     * @Groups({"residents_read"})
     * @ApiSubresource
     */
    private $dayChecks;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="residents")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"residents_read"})
     */
    private $createdBy;

    public function __construct()
    {
        $this->diets = new ArrayCollection();
        $this->textures = new ArrayCollection();
        $this->dayChecks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getRoom(): ?string
    {
        return $this->room;
    }

    public function setRoom(string $room): self
    {
        $this->room = $room;

        return $this;
    }

    public function getBornAt(): ?\DateTimeInterface
    {
        return $this->bornAt;
    }

    public function setBornAt(\DateTimeInterface $bornAt): self
    {
        $this->bornAt = $bornAt;

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



    public function getUnity(): ?Unity
    {
        return $this->unity;
    }

    public function setUnity(?Unity $unity): self
    {
        $this->unity = $unity;

        return $this;
    }

    /**
     * @return Collection|Diet[]
     */
    public function getDiets(): Collection
    {
        return $this->diets;
    }

    public function addDiet(Diet $diet): self
    {
        if (!$this->diets->contains($diet)) {
            $this->diets[] = $diet;
            $diet->addResident($this);
        }

        return $this;
    }

    public function removeDiet(Diet $diet): self
    {
        if ($this->diets->removeElement($diet)) {
            $diet->removeResident($this);
        }

        return $this;
    }

    /**
     * @return Collection|Texture[]
     */
    public function getTextures(): Collection
    {
        return $this->textures;
    }

    public function addTexture(Texture $texture): self
    {
        if (!$this->textures->contains($texture)) {
            $this->textures[] = $texture;
            $texture->addResident($this);
        }

        return $this;
    }

    public function removeTexture(Texture $texture): self
    {
        if ($this->textures->removeElement($texture)) {
            $texture->removeResident($this);
        }

        return $this;
    }

    /**
     * @return Collection|DayCheck[]
     */
    public function getDayChecks(): Collection
    {
        return $this->dayChecks;
    }

    public function addDayCheck(DayCheck $dayCheck): self
    {
        if (!$this->dayChecks->contains($dayCheck)) {
            $this->dayChecks[] = $dayCheck;
            $dayCheck->setResident($this);
        }

        return $this;
    }

    public function removeDayCheck(DayCheck $dayCheck): self
    {
        if ($this->dayChecks->removeElement($dayCheck)) {
            // set the owning side to null (unless already changed)
            if ($dayCheck->getResident() === $this) {
                $dayCheck->setResident(null);
            }
        }

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
