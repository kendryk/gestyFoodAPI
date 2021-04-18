<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\DayRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=DayRepository::class)
 * * @ApiResource(
 *  normalizationContext={
 *      "groups"={"days_read"}
 * }
 * )
 */
class Day
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"days_read","dayChecks_read", "residents_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"days_read","dayChecks_read", "residents_read"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"days_read","dayChecks_read", "residents_read"})
     */
    private $checkTime;

    /**
     * @ORM\ManyToOne(targetEntity=DayCheck::class, inversedBy="days")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"days_read","dayChecks_read", "residents_read"})
     */
    private $dayCheck;

    /**
     * @ORM\ManyToOne(targetEntity=Hearth::class, inversedBy="days")
     * @ORM\JoinColumn(nullable=false)
     */
    private $hearth;



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

    public function setCheckTime(?string $checkTime): self
    {
        $this->checkTime = $checkTime;

        return $this;
    }

    public function getDayCheck(): ?DayCheck
    {
        return $this->dayCheck;
    }

    public function setDayCheck(?DayCheck $dayCheck): self
    {
        $this->dayCheck = $dayCheck;

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
