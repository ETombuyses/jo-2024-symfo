<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OlympicEvent
 *
 * @ORM\Table(name="olympic_event", indexes={@ORM\Index(name="olympic_event_arrondissement0_FK", columns={"id_arrondissement"}), @ORM\Index(name="olympic_event_sports_practice_FK", columns={"id_sports_practice"})})
 * @ORM\Entity(repositoryClass="App\Repository\OlympicEventRepository")
 */
class OlympicEvent
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
     * @ORM\Column(name="event_name", type="string", length=50, nullable=false)
     */
    private $eventName;

    /**
     * @var string
     *
     * @ORM\Column(name="event_place", type="string", length=50, nullable=false)
     */
    private $eventPlace;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

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

    public function getEventName(): ?string
    {
        return $this->eventName;
    }

    public function setEventName(string $eventName): self
    {
        $this->eventName = $eventName;

        return $this;
    }

    public function getEventPlace(): ?string
    {
        return $this->eventPlace;
    }

    public function setEventPlace(string $eventPlace): self
    {
        $this->eventPlace = $eventPlace;

        return $this;
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

    public function getIdArrondissement(): ?Arrondissement
    {
        return $this->idArrondissement;
    }

    public function setIdArrondissement(?Arrondissement $idArrondissement): self
    {
        $this->idArrondissement = $idArrondissement;

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
