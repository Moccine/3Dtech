<?php
declare(strict_types=1);

namespace App\Entity\Traits;

use App\Entity\Address;
use Doctrine\ORM\Mapping as ORM;

trait AddressTrait
{
    use CreatedAtTrait;
    use UpdatedAtTrait;
    use IdentifiableTrait;

    /**
     * @ORM\Column(type="string", length=125, nullable=true)
     */
    private string $street;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private string $city;

    /**
     * @ORM\Column(type="string", length=125, nullable=true)
     */
    private string $country;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private string $postalCode;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $longitude;


    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;
        $this->country = Address::FRANCE;
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

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * @param float|null $longitude la longitude
     *
     * @return $this
     */
    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getGeoPoint()
    {
        $location = [
            'lat' => $this->getLatitude(),
            'lon' => $this->getLongitude(),
        ];

        return ($this->getLatitude() && $this->getLongitude()) ? $location : null;
    }


    public function __toString(): string
    {
        return sprintf('%s %s %s', $this->address, $this->postalCode, $this->city);
    }

}
