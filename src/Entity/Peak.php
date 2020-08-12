<?php

namespace App\Entity;

use App\Repository\PeakRepository;
use Doctrine\ORM\Mapping as ORM;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

/**
 * @ORM\Entity(repositoryClass=PeakRepository::class)
 */
class Peak
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @SWG\Property(description="The unique identifier of the peak")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @SWG\Property(description="The name of the peak", type="string", maxLength=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * @SWG\Property(description="The latitude of the peak")
     */
    private $lat;

    /**
     * @ORM\Column(type="float")
     * @SWG\Property(description="The longitude of the peak")
     */
    private $lon;

    /**
     * @ORM\Column(type="float")
     * @SWG\Property(description="The altitude of the peak")
     */
    private $alt;

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

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLon(): ?float
    {
        return $this->lon;
    }

    public function setLon(float $lon): self
    {
        $this->lon = $lon;

        return $this;
    }

    public function getAlt(): ?float
    {
        return $this->alt;
    }

    public function setAlt(float $alt): self
    {
        $this->alt = $alt;

        return $this;
    }
}
