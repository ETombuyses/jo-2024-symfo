<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * SportsFacility
 *
 * @ORM\Table(name="sports_facility", indexes={@ORM\Index(name="sports_facility_arrondissement_FK", columns={"id_arrondissement"})})
 * @ORM\Entity(repositoryClass="App\Repository\SportsFacilityRepository")
 */
class SportsFacility
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
     * @ORM\Column(name="facility_type", type="text", length=65535, nullable=false)
     */
    private $facilityType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="facility_name", type="text", length=65535, nullable=true)
     */
    private $facilityName;

    /**
     * @var int
     *
     * @ORM\Column(name="address_number", type="integer", nullable=false)
     */
    private $addressNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="address_street", type="text", length=65535, nullable=false)
     */
    private $addressStreet;

    /**
     * @var \Arrondissement
     *
     * @ORM\ManyToOne(targetEntity="Arrondissement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_arrondissement", referencedColumnName="id")
     * })
     */
    private $idArrondissement;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="SportsPractice", mappedBy="idSportsFacility")
     */
    private $idSportsPractice;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idSportsPractice = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFacilityType(): ?string
    {
        return $this->facilityType;
    }

    public function setFacilityType(string $facilityType): self
    {
        $this->facilityType = $facilityType;

        return $this;
    }

    public function getFacilityName(): ?string
    {
        return $this->facilityName;
    }

    public function setFacilityName(?string $facilityName): self
    {
        $this->facilityName = $facilityName;

        return $this;
    }

    public function getAddressNumber(): ?int
    {
        return $this->addressNumber;
    }

    public function setAddressNumber(int $addressNumber): self
    {
        $this->addressNumber = $addressNumber;

        return $this;
    }

    public function getAddressStreet(): ?string
    {
        return $this->addressStreet;
    }

    public function setAddressStreet(string $addressStreet): self
    {
        $this->addressStreet = $addressStreet;

        return $this;
    }

    public function getIdArrondissement(): ?Arrondissement
    {
        return $this->idArrondissement;
    }

    public function setIdArrondissement(?Arrondissement $idArrondissement): self
    {
        $this->idArrondissement = $idArrondissement;

        return $this;
    }

    /**
     * @return Collection|SportsPractice[]
     */
    public function getIdSportsPractice(): Collection
    {
        return $this->idSportsPractice;
    }

    public function addIdSportsPractice(SportsPractice $idSportsPractice): self
    {
        if (!$this->idSportsPractice->contains($idSportsPractice)) {
            $this->idSportsPractice[] = $idSportsPractice;
            $idSportsPractice->addIdSportsFacility($this);
        }

        return $this;
    }

    public function removeIdSportsPractice(SportsPractice $idSportsPractice): self
    {
        if ($this->idSportsPractice->contains($idSportsPractice)) {
            $this->idSportsPractice->removeElement($idSportsPractice);
            $idSportsPractice->removeIdSportsFacility($this);
        }

        return $this;
    }

}
