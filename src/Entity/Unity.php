<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\UnityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UnityRepository::class)
 * @ApiResource(
 *  normalizationContext={
 *      "groups"={"unities_read"}
 * }
 * )
 */
class Unity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"unities_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"unities_read", "residents_read", "hearths_read"})
     * @Assert\NotBlank(message="Le nom de l'unité est obligatoire")
     * @Assert\Length(min=3, minMessage="Le nom doit faire entre 3 et 255 caractères",
     *      max=255, maxMessage="Le nom doit faire entre 3 et 255 caractères")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"unities_read"})
     */
    private $photo;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"unities_read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"unities_read"})
     */
    private $UpdateAt;



    /**
     * @ORM\OneToMany(targetEntity=Resident::class, mappedBy="unity", orphanRemoval=true)
     * @Groups({"unities_read"})
     * @ApiSubresource
     */
    private $residents;

    /**
     * @ORM\ManyToOne(targetEntity=Hearth::class, inversedBy="unities")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"unities_read", "residents_read"})
     */
    private $hearth;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="unities")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"unities_read"})
     */
    private $createdBy;

    public function __construct()
    {
        $this->residents = new ArrayCollection();
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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

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
        return $this->UpdateAt;
    }

    public function setUpdateAt(\DateTimeInterface $UpdateAt): self
    {
        $this->UpdateAt = $UpdateAt;

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
            $resident->setUnity($this);
        }

        return $this;
    }

    public function removeResident(Resident $resident): self
    {
        if ($this->residents->removeElement($resident)) {
            // set the owning side to null (unless already changed)
            if ($resident->getUnity() === $this) {
                $resident->setUnity(null);
            }
        }

        return $this;
    }

    public function getHearth(): ?Hearth
    {
        return $this->hearth;
    }

    public function setHearth(?Hearth $hearth): self
    {
        $this->hearth = $hearth;

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
