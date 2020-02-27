<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * SportsPractice
 *
 * @ORM\Table(name="sports_practice")
 * @ORM\Entity(repositoryClass="App\Repository\SportsPracticeRepository")
 */
class SportsPractice
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
     * @ORM\Column(name="practice", type="text", length=65535, nullable=false)
     */
    private $practice;

    /**
     * @var string
     *
     * @ORM\Column(name="image_name", type="text", length=65535, nullable=false)
     */
    private $imageName;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="SportsFacility", inversedBy="idSportsPractice")
     * @ORM\JoinTable(name="facility_practice_association",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_sports_practice", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_sports_facility", referencedColumnName="id")
     *   }
     * )
     */
    private $idSportsFacility;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="SportsFamily", inversedBy="idPractice")
     * @ORM\JoinTable(name="sports_family_practice_association",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_practice", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_sports_family", referencedColumnName="id")
     *   }
     * )
     */
    private $idSportsFamily;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idSportsFacility = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idSportsFamily = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPractice(): ?string
    {
        return $this->practice;
    }

    public function setPractice(string $practice): self
    {
        $this->practice = $practice;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return Collection|SportsFacility[]
     */
    public function getIdSportsFacility(): Collection
    {
        return $this->idSportsFacility;
    }

    public function addIdSportsFacility(SportsFacility $idSportsFacility): self
    {
        if (!$this->idSportsFacility->contains($idSportsFacility)) {
            $this->idSportsFacility[] = $idSportsFacility;
        }

        return $this;
    }

    public function removeIdSportsFacility(SportsFacility $idSportsFacility): self
    {
        if ($this->idSportsFacility->contains($idSportsFacility)) {
            $this->idSportsFacility->removeElement($idSportsFacility);
        }

        return $this;
    }

    /**
     * @return Collection|SportsFamily[]
     */
    public function getIdSportsFamily(): Collection
    {
        return $this->idSportsFamily;
    }

    public function addIdSportsFamily(SportsFamily $idSportsFamily): self
    {
        if (!$this->idSportsFamily->contains($idSportsFamily)) {
            $this->idSportsFamily[] = $idSportsFamily;
        }

        return $this;
    }

    public function removeIdSportsFamily(SportsFamily $idSportsFamily): self
    {
        if ($this->idSportsFamily->contains($idSportsFamily)) {
            $this->idSportsFamily->removeElement($idSportsFamily);
        }

        return $this;
    }

}
