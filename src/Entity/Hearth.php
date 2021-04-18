<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\HearthRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=HearthRepository::class)
 * @ApiResource(
 *  normalizationContext={
 *      "groups"={"hearths_read"}},
 *  denormalizationContext={
 *      "groups"={"hearths_create"}
 *     }
 *
 * )
 */
class Hearth
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"hearths_read", "hearths_create", "users_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     * @Groups({"hearths_read", "users_read", "unities_read", "residents_read", "hearths_create"})
     * @Assert\NotBlank(message="Nom du foyer  obligatoire")
     * @Assert\Length(min=3, minMessage="Le Nom doit faire entre 3 et 255 caractères",
     *     max=255, maxMessage="Le Nom doit faire entre 3 et 255 caractères")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"hearths_read", "users_read", "unities_read", "hearths_create"})
     * @Assert\NotBlank(message="Adresse du foyer  obligatoire")
     * @Assert\Length(min=3, minMessage="L'Adresse doit faire entre 3 et 255 caractères",
     *     max=255, maxMessage="L'Adresse doit faire entre 3 et 255 caractères")
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"hearths_read", "users_read", "unities_read", "hearths_create"})
     * @Assert\NotBlank(message="Nom de la ville  obligatoire")
     * @Assert\Length(min=3, minMessage="La ville doit faire entre 3 et 255 caractères",
     *     max=255, maxMessage="La ville doit faire entre 3 et 255 caractères")
     */
    private $city;

    /**
     * @ORM\Column(type="bigint", nullable=true)
     * @Groups({"hearths_read", "users_read", "hearths_create"})
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"hearths_read", "users_read", "hearths_create"})
     * @Assert\NotBlank(message="Email obligatoire")
     * @Assert\Email(message="Le format de l'adresse email doit être valide")
     */
    private $email;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"hearths_read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"hearths_read"})
     */
    private $updateAt;


    /**
     * @ORM\OneToMany(targetEntity=Unity::class, mappedBy="hearth", orphanRemoval=true)
     * @Groups({"hearths_read"})
     */
    private $unities;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="hearth", orphanRemoval=true)
     * @Groups({"hearths_read"})
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Resident::class, mappedBy="hearth", orphanRemoval=true)
     */
    private $residents;

    /**
     * @ORM\OneToMany(targetEntity=Texture::class, mappedBy="hearth", orphanRemoval=true)
     */
    private $textures;

    /**
     * @ORM\OneToMany(targetEntity=DayCheck::class, mappedBy="hearth")
     */
    private $dayChecks;

    /**
     * @ORM\OneToMany(targetEntity=Day::class, mappedBy="hearth", orphanRemoval=true)
     */
    private $days;



    public function __construct()
    {
        $this->unities = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->residents = new ArrayCollection();
        $this->textures = new ArrayCollection();
        $this->dayChecks = new ArrayCollection();
        $this->days = new ArrayCollection();
    }

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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



    /**
     * @return Collection|Unity[]
     */
    public function getUnities(): Collection
    {
        return $this->unities;
    }

    public function addUnity(Unity $unity): self
    {
        if (!$this->unities->contains($unity)) {
            $this->unities[] = $unity;
            $unity->setHearth($this);
        }

        return $this;
    }

    public function removeUnity(Unity $unity): self
    {
        if ($this->unities->removeElement($unity)) {
            // set the owning side to null (unless already changed)
            if ($unity->getHearth() === $this) {
                $unity->setHearth(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setHearth($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getHearth() === $this) {
                $user->setHearth(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Resident[]
     */
    public function getResidents(): Collection
    {
        return $this->residents;
    }

    public function addResident(Resident $resident): self
    {
        if (!$this->residents->contains($resident)) {
            $this->residents[] = $resident;
            $resident->setHearth($this);
        }

        return $this;
    }

    public function removeResident(Resident $resident): self
    {
        if ($this->residents->removeElement($resident)) {
            // set the owning side to null (unless already changed)
            if ($resident->getHearth() === $this) {
                $resident->setHearth(null);
            }
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
            $texture->setHearth($this);
        }

        return $this;
    }

    public function removeTexture(Texture $texture): self
    {
        if ($this->textures->removeElement($texture)) {
            // set the owning side to null (unless already changed)
            if ($texture->getHearth() === $this) {
                $texture->setHearth(null);
            }
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
            $dayCheck->setHearth($this);
        }

        return $this;
    }

    public function removeDayCheck(DayCheck $dayCheck): self
    {
        if ($this->dayChecks->removeElement($dayCheck)) {
            // set the owning side to null (unless already changed)
            if ($dayCheck->getHearth() === $this) {
                $dayCheck->setHearth(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Day[]
     */
    public function getDays(): Collection
    {
        return $this->days;
    }

    public function addDay(Day $day): self
    {
        if (!$this->days->contains($day)) {
            $this->days[] = $day;
            $day->setHearth($this);
        }

        return $this;
    }

    public function removeDay(Day $day): self
    {
        if ($this->days->removeElement($day)) {
            // set the owning side to null (unless already changed)
            if ($day->getHearth() === $this) {
                $day->setHearth(null);
            }
        }

        return $this;
    }






}
