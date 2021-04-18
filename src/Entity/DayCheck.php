<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\DayCheckRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @Groups({"dayChecks_read", "residents_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     * @Groups({"dayChecks_read", "residents_read"})
     */
    private $name;



    /**
     * @ORM\Column(type="datetime")
     * @Groups({"dayChecks_read", "residents_read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"dayChecks_read", "residents_read"})
     */
    private $updateAt;





    /**
     * @ORM\ManyToOne(targetEntity=Resident::class, inversedBy="dayChecks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $resident;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="dayChecks")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"dayChecks_read"})
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity=Diet::class, inversedBy="dayChecks")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"dayChecks_read", "residents_read"})
     */
    private $diet;

    /**
     * @ORM\ManyToOne(targetEntity=Texture::class, inversedBy="dayChecks")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"dayChecks_read", "residents_read"})
     */
    private $texture;


    /**
     * @ORM\ManyToOne(targetEntity=Hearth::class, inversedBy="dayChecks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $hearth;

    /**
     * @ORM\OneToMany(targetEntity=Day::class, mappedBy="dayCheck", orphanRemoval=true)
     */
    private $days;

    public function __construct()
    {
        $this->days = new ArrayCollection();
    }


//    ************************************************************************

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

    public function getDiet(): ?Diet
    {
        return $this->diet;
    }

    public function setDiet(?Diet $diet): self
    {
        $this->diet = $diet;

        return $this;
    }

    public function getTexture(): ?Texture
    {
        return $this->texture;
    }

    public function setTexture(?Texture $texture): self
    {
        $this->texture = $texture;

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
            $day->setDayCheck($this);
        }

        return $this;
    }

    public function removeDay(Day $day): self
    {
        if ($this->days->removeElement($day)) {
            // set the owning side to null (unless already changed)
            if ($day->getDayCheck() === $this) {
                $day->setDayCheck(null);
            }
        }

        return $this;
    }
}
