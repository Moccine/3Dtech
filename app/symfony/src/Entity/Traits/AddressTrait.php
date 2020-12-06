<?php
declare(strict_types=1);

namespace App\Entity\Traits;

use App\Entity\Address;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

trait AddressTrait
{
    /**
     * @ORM\Column(type="string", length=125)
     * @Assert\NotBlank()
     */
    private string $address;

    /**
     * @ORM\Column(type="string", length=125)
     * @Assert\NotBlank()
     */
    private string $city;

    /**
     * @ORM\Column(type="string", length=125)
     * @Assert\NotBlank()
     */
    private string $country;

    /**
     * @ORM\Column(type="string", length=16)
     * @Assert\NotBlank()
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


    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;
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
