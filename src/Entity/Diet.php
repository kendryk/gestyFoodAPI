<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DietRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=DietRepository::class)
 * @ApiResource(
 *  normalizationContext={
 *      "groups"={"diets_read"}
 * }
 * )
 */
class Diet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"diets_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     * @Groups({"diets_read", "residents_read"})
     * @Assert\NotBlank(message="Nom du regime  obligatoire")
     * @Assert\Length(min=3, minMessage="Le regime  doit faire entre 3 et 255 caractères",
     *     max=255, maxMessage="Le regimedoit faire entre 3 et 255 caractères")
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"diets_read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"diets_read"})
     */
    private $updateAt;



    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="diets")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"diets_read"})
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity=Hearth::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $hearth;

    /**
     * @ORM\OneToMany(targetEntity=DayCheck::class, mappedBy="diet")
     */
    private $dayChecks;

//*****************************************************************
    public function __construct()
    {
        $this->dayChecks = new ArrayCollection();
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





    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

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
            $dayCheck->setDiet($this);
        }

        return $this;
    }

    public function removeDayCheck(DayCheck $dayCheck): self
    {
        if ($this->dayChecks->removeElement($dayCheck)) {
            // set the owning side to null (unless already changed)
            if ($dayCheck->getDiet() === $this) {
                $dayCheck->setDiet(null);
            }
        }

        return $this;
    }
}
