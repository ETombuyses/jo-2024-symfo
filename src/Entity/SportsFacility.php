<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SportsFacility
 *
 * @ORM\Table(name="sports_facility", indexes={@ORM\Index(name="sports_facility_sports_facility_type0_FK", columns={"id_sports_facility_type"}), @ORM\Index(name="sports_facility_sports_practice_FK", columns={"id_sports_practice"}), @ORM\Index(name="sports_facility_arrondissement1_FK", columns={"id_arrondissement"})})
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
     * @var string|null
     *
     * @ORM\Column(name="practice_level", type="string", length=50, nullable=true)
     */
    private $practiceLevel;

    /**
     * @var bool
     *
     * @ORM\Column(name="handicap_access_mobility_sport_area", type="boolean", nullable=false)
     */
    private $handicapAccessMobilitySportArea;

    /**
     * @var bool
     *
     * @ORM\Column(name="handicap_access_sensory_sport_area", type="boolean", nullable=false)
     */
    private $handicapAccessSensorySportArea;

    /**
     * @var bool
     *
     * @ORM\Column(name="handicap_access_sensory_locker_room", type="boolean", nullable=false)
     */
    private $handicapAccessSensoryLockerRoom;

    /**
     * @var bool
     *
     * @ORM\Column(name="handicap_access_mobility_locker_room", type="boolean", nullable=false)
     */
    private $handicapAccessMobilityLockerRoom;

    /**
     * @var bool
     *
     * @ORM\Column(name="handicap_access_mobility_swimming_pool", type="boolean", nullable=false)
     */
    private $handicapAccessMobilitySwimmingPool;

    /**
     * @var bool
     *
     * @ORM\Column(name="handicap_access_sensory_sanitary", type="boolean", nullable=false)
     */
    private $handicapAccessSensorySanitary;

    /**
     * @var bool
     *
     * @ORM\Column(name="handicap_access_mobility_sanitary", type="boolean", nullable=false)
     */
    private $handicapAccessMobilitySanitary;

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
     * @var \SportsFacilityType
     *
     * @ORM\ManyToOne(targetEntity="SportsFacilityType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_sports_facility_type", referencedColumnName="id")
     * })
     */
    private $idSportsFacilityType;

    /**
     * @var \SportsPractice
     *
     * @ORM\ManyToOne(targetEntity="SportsPractice")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_sports_practice", referencedColumnName="id")
     * })
     */
    private $idSportsPractice;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPracticeLevel(): ?string
    {
        return $this->practiceLevel;
    }

    public function setPracticeLevel(?string $practiceLevel): self
    {
        $this->practiceLevel = $practiceLevel;

        return $this;
    }

    public function getHandicapAccessMobilitySportArea(): ?bool
    {
        return $this->handicapAccessMobilitySportArea;
    }

    public function setHandicapAccessMobilitySportArea(bool $handicapAccessMobilitySportArea): self
    {
        $this->handicapAccessMobilitySportArea = $handicapAccessMobilitySportArea;

        return $this;
    }

    public function getHandicapAccessSensorySportArea(): ?bool
    {
        return $this->handicapAccessSensorySportArea;
    }

    public function setHandicapAccessSensorySportArea(bool $handicapAccessSensorySportArea): self
    {
        $this->handicapAccessSensorySportArea = $handicapAccessSensorySportArea;

        return $this;
    }

    public function getHandicapAccessSensoryLockerRoom(): ?bool
    {
        return $this->handicapAccessSensoryLockerRoom;
    }

    public function setHandicapAccessSensoryLockerRoom(bool $handicapAccessSensoryLockerRoom): self
    {
        $this->handicapAccessSensoryLockerRoom = $handicapAccessSensoryLockerRoom;

        return $this;
    }

    public function getHandicapAccessMobilityLockerRoom(): ?bool
    {
        return $this->handicapAccessMobilityLockerRoom;
    }

    public function setHandicapAccessMobilityLockerRoom(bool $handicapAccessMobilityLockerRoom): self
    {
        $this->handicapAccessMobilityLockerRoom = $handicapAccessMobilityLockerRoom;

        return $this;
    }

    public function getHandicapAccessMobilitySwimmingPool(): ?bool
    {
        return $this->handicapAccessMobilitySwimmingPool;
    }

    public function setHandicapAccessMobilitySwimmingPool(bool $handicapAccessMobilitySwimmingPool): self
    {
        $this->handicapAccessMobilitySwimmingPool = $handicapAccessMobilitySwimmingPool;

        return $this;
    }

    public function getHandicapAccessSensorySanitary(): ?bool
    {
        return $this->handicapAccessSensorySanitary;
    }

    public function setHandicapAccessSensorySanitary(bool $handicapAccessSensorySanitary): self
    {
        $this->handicapAccessSensorySanitary = $handicapAccessSensorySanitary;

        return $this;
    }

    public function getHandicapAccessMobilitySanitary(): ?bool
    {
        return $this->handicapAccessMobilitySanitary;
    }

    public function setHandicapAccessMobilitySanitary(bool $handicapAccessMobilitySanitary): self
    {
        $this->handicapAccessMobilitySanitary = $handicapAccessMobilitySanitary;

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

    public function getIdSportsFacilityType(): ?SportsFacilityType
    {
        return $this->idSportsFacilityType;
    }

    public function setIdSportsFacilityType(?SportsFacilityType $idSportsFacilityType): self
    {
        $this->idSportsFacilityType = $idSportsFacilityType;

        return $this;
    }

    public function getIdSportsPractice(): ?SportsPractice
    {
        return $this->idSportsPractice;
    }

    public function setIdSportsPractice(?SportsPractice $idSportsPractice): self
    {
        $this->idSportsPractice = $idSportsPractice;

        return $this;
    }


}
