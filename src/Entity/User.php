<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ApiResource(
 *  normalizationContext={
 *      "groups"={"users_read"}
 * }
 * )
 * @UniqueEntity("email", message="un utilisateur ayant cette adresse existe déjà")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"users_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"users_read"})
     * @Assert\NotBlank(message="Email obligatoire")
     * @Assert\Email(message="Le format de l'adresse email doit être valide")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"users_read"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Email obligatoire")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"users_read", "hearths_read"})
     * @Assert\NotBlank(message="prenom de l'user obligatoire")
     * @Assert\Length(min=2, minMessage="Le prenom de l'user doit faire entre 2 et 255 caractères",
     *     max=255, maxMessage="Le prenom de l'user doit faire entre 2 et 255 caractères")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"users_read", "hearths_read"})
     * @Assert\NotBlank(message="Nom de l'user obligatoire")
     * @Assert\Length(min=2, minMessage="Le Nom doit faire entre 2 et 255 caractères",
     *     max=255, maxMessage="Le Nom doit faire entre 2 et 255 caractères")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"users_read"})
     * @Assert\NotBlank(message="Nom du poste  obligatoire")
     * @Assert\Length(min=3, minMessage="Le Nom doit faire entre 3 et 255 caractères",
     *     max=255, maxMessage="Le Nom doit faire entre 3 et 255 caractères")
     */
    private $work;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"users_read"})
     */
    private $phone;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"users_read"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"users_read"})
     */
    private $updateAt;

    /**
     * @ORM\ManyToOne(targetEntity=Hearth::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"users_read"})
     */
    private $hearth;

    /**
     * @ORM\OneToMany(targetEntity=DayCheck::class, mappedBy="createdBy", orphanRemoval=true)
     */
    private $dayChecks;

    /**
     * @ORM\OneToMany(targetEntity=Diet::class, mappedBy="createdBy", orphanRemoval=true)
     */
    private $diets;

    /**
     * @ORM\OneToMany(targetEntity=Hearth::class, mappedBy="createdBy")
     */
    private $hearths;

    /**
     * @ORM\OneToMany(targetEntity=Resident::class, mappedBy="createdBy", orphanRemoval=true)
     */
    private $residents;

    /**
     * @ORM\OneToMany(targetEntity=Texture::class, mappedBy="createdBy", orphanRemoval=true)
     */
    private $textures;

    /**
     * @ORM\OneToMany(targetEntity=Unity::class, mappedBy="createdBy", orphanRemoval=true)
     */
    private $unities;


    public function __construct()
    {
        $this->dayChecks = new ArrayCollection();
        $this->diets = new ArrayCollection();
        $this->hearths = new ArrayCollection();
        $this->residents = new ArrayCollection();
        $this->textures = new ArrayCollection();
        $this->unities = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getWork(): ?string
    {
        return $this->work;
    }

    public function setWork(string $work): self
    {
        $this->work = $work;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

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



    /**
     * @return Collection|Diet[]
     */
    public function getDiets(): Collection
    {
        return $this->diets;
    }

    /**
     * @return Collection|Hearth[]
     */
    public function getHearths(): Collection
    {
        return $this->hearths;
    }

    /**
     * @return Collection|Resident[]
     */
    public function getResidents(): Collection
    {
        return $this->residents;
    }

    /**
     * @return Collection|Texture[]
     */
    public function getTextures(): Collection
    {
        return $this->textures;
    }

    /**
     * @return Collection|Unity[]
     */
    public function getUnities(): Collection
    {
        return $this->unities;
    }






}
