<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TextureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TextureRepository::class)
 * @ApiResource(
 *  normalizationContext={
 *      "groups"={"textures_read"}
 * }
 * )
 */
class Texture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"textures_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"textures_read", "residents_read"})
     * @Assert\NotBlank(message="Nom de la texture  obligatoire")
     * @Assert\Length(min=3, minMessage="Le nom de la texture doit faire entre 3 et 255 caractères",
     *     max=255, maxMessage="Le nom de la texture doit faire entre 3 et 255 caractères")
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"textures_read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"textures_read"})
     */
    private $updateAt;


    /**
     * @ORM\OneToMany(targetEntity=DayCheck::class, mappedBy="texture")
     */
    private $dayChecks;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="textures")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"textures_read"})
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity=Hearth::class, inversedBy="textures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $hearth;

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
            $dayCheck->setTexture($this);
        }

        return $this;
    }

    public function removeDayCheck(DayCheck $dayCheck): self
    {
        if ($this->dayChecks->removeElement($dayCheck)) {
            // set the owning side to null (unless already changed)
            if ($dayCheck->getTexture() === $this) {
                $dayCheck->setTexture(null);
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

    public function getHearth(): ?Hearth
    {
        return $this->hearth;
    }

    public function setHearth(?Hearth $hearth): self
    {
        $this->hearth = $hearth;

        return $this;
    }
}
