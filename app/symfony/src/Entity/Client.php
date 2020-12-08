<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\AddressTrait;
use App\Entity\Traits\IdentifiableTrait;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    public const TYPE_INDIVIDUAL = 'Personnel';
    public const TYPE_PROFESSIONAL = 'Entreprise';

    public static array $types = [
        self::TYPE_INDIVIDUAL  => self::TYPE_INDIVIDUAL,
        self::TYPE_PROFESSIONAL =>  self::TYPE_PROFESSIONAL
    ];

    use IdentifiableTrait;
     use AddressTrait;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $company;

    /**
     * @ORM\Column(type="string", length=125, nullable=false)
     * @Assert\NotBlank()
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string", length=125, nullable=false)
     * @Assert\NotBlank()
     */
    private string $lastName;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     * @Assert\NotBlank()
     */
    private string $mobilePhone;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private string $homePhone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $siret;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private string $type = self::TYPE_INDIVIDUAL;

    /**
     * @ORM\OneToOne(targetEntity=User::class)
     */
    private User $user;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="client")
     */
    private Collection $orders;

    /**
     * @ORM\OneToMany(targetEntity=Quotation::class, mappedBy="client")
     */
    private $quotation;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->quotation = new ArrayCollection();
    }

    public function getCompany(): ?string
    {
        return $this->company ?? null;
    }

    public function setCompany(?string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getMobilePhone(): string
    {
        return $this->mobilePhone;
    }

    public function setMobilePhone(string $phone): self
    {
        $this->mobilePhone = $phone;

        return $this;
    }

    public function getHomePhone():?string
    {
        return $this->homePhone;
    }

    public function setHomePhone(?string $phone): self
    {
        $this->homePhone = $phone;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret ?? null;
    }

    public function setSiret(?string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setClient($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getClient() === $this) {
                $order->setClient(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->company??$this->firstName;
    }

    /**
     * @return Collection|Quotation[]
     */
    public function getQuotation(): Collection
    {
        return $this->quotation;
    }

    public function addQuotation(Quotation $quotation): self
    {
        if (!$this->quotation->contains($quotation)) {
            $this->quotation[] = $quotation;
            $quotation->setClient($this);
        }

        return $this;
    }

    public function removeQuotation(Quotation $quotation): self
    {
        if ($this->quotation->removeElement($quotation)) {
            // set the owning side to null (unless already changed)
            if ($quotation->getClient() === $this) {
                $quotation->setClient(null);
            }
        }

        return $this;
    }

}
