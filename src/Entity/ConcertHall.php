<?php

namespace App\Entity;

use App\Repository\ConcertHallRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConcertHallRepository::class)
 */
class ConcertHall
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalPlaces;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $presentation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\OneToMany(targetEntity=Hall::class, mappedBy="concertHall")
     */
    private $Hall;

    public function __construct()
    {
        $this->Hall = new ArrayCollection();
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

    public function getTotalPlaces(): ?int
    {
        return $this->totalPlaces;
    }

    public function setTotalPlaces(int $totalPlaces): self
    {
        $this->totalPlaces = $totalPlaces;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

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

    /**
     * @return Collection|Hall[]
     */
    public function getHall(): Collection
    {
        return $this->Hall;
    }

    public function addHall(Hall $hall): self
    {
        if (!$this->Hall->contains($hall)) {
            $this->Hall[] = $hall;
            $hall->setConcertHall($this);
        }

        return $this;
    }

    public function removeHall(Hall $hall): self
    {
        if ($this->Hall->removeElement($hall)) {
            // set the owning side to null (unless already changed)
            if ($hall->getConcertHall() === $this) {
                $hall->setConcertHall(null);
            }
        }

        return $this;
    }
}
