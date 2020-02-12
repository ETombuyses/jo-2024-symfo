<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Arrondissement
 *
 * @ORM\Table(name="arrondissement")
 * @ORM\Entity(repositoryClass="App\Repository\ArrondissementRepository")
 */
class Arrondissement
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
     * @var int
     *
     * @ORM\Column(name="insee_code", type="integer", nullable=false)
     */
    private $inseeCode;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var float|null
     *
     * @ORM\Column(name="surface_km_square", type="float", precision=10, scale=0, nullable=true)
     */
    private $surfaceKmSquare;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInseeCode(): ?int
    {
        return $this->inseeCode;
    }

    public function setInseeCode(int $inseeCode): self
    {
        $this->inseeCode = $inseeCode;

        return $this;
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

    public function getSurfaceKmSquare(): ?float
    {
        return $this->surfaceKmSquare;
    }

    public function setSurfaceKmSquare(?float $surfaceKmSquare): self
    {
        $this->surfaceKmSquare = $surfaceKmSquare;

        return $this;
    }


}
