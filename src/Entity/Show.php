<?php

namespace App\Entity;

use App\Repository\ShowRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShowRepository::class)
 * @ORM\Table(name="`showT`")
 */
class Show
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Hall::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $hall;

    /**
     * @ORM\ManyToMany(targetEntity=Band::class)
     */
    private $band;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tournee;

    public function __construct()
    {
        $this->band = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getHall(): ?Hall
    {
        return $this->hall;
    }

    public function setHall(?Hall $hall): self
    {
        $this->hall = $hall;

        return $this;
    }

    /**
     * @return Collection|Band[]
     */
    public function getBand(): Collection
    {
        return $this->band;
    }

    public function addBand(Band $band): self
    {
        if (!$this->band->contains($band)) {
            $this->band[] = $band;
        }

        return $this;
    }

    public function removeBand(Band $band): self
    {
        $this->band->removeElement($band);

        return $this;
    }

    public function getTournee(): ?string
    {
        return $this->tournee;
    }

    public function setTournee(string $tournee): self
    {
        $this->tournee = $tournee;

        return $this;
    }
}
