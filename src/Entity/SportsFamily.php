<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * SportsFamily
 *
 * @ORM\Table(name="sports_family")
 * @ORM\Entity(repositoryClass="App\Repository\SportsFamilyRepository")
 */
class SportsFamily
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="sports_family_name", type="string", length=50, nullable=false)
     */
    private $sportsFamilyName;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="SportsPractice", mappedBy="idSportsFamily")
     */
    private $idPractice;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idPractice = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSportsFamilyName(): ?string
    {
        return $this->sportsFamilyName;
    }

    public function setSportsFamilyName(string $sportsFamilyName): self
    {
        $this->sportsFamilyName = $sportsFamilyName;

        return $this;
    }

    /**
     * @return Collection|SportsPractice[]
     */
    public function getIdPractice(): Collection
    {
        return $this->idPractice;
    }

    public function addIdPractice(SportsPractice $idPractice): self
    {
        if (!$this->idPractice->contains($idPractice)) {
            $this->idPractice[] = $idPractice;
            $idPractice->addIdSportsFamily($this);
        }

        return $this;
    }

    public function removeIdPractice(SportsPractice $idPractice): self
    {
        if ($this->idPractice->contains($idPractice)) {
            $this->idPractice->removeElement($idPractice);
            $idPractice->removeIdSportsFamily($this);
        }

        return $this;
    }

}
