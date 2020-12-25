<?php
declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Traits\UpdatedAtTrait;
use App\Repository\VoucherRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VoucherRepository::class)
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"voucher" = "App\Entity\Voucher", "entry" = "App\Entity\Voucher\Entry", "release" = "App\Entity\Voucher\Release"})
 * @ORM\HasLifecycleCallbacks()
 */
class Voucher
{
    use CreatedAtTrait;
    use UpdatedAtTrait;
    use IdentifiableTrait;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="vouchers")
     */
    private Product $product;

    /**
     * @ORM\ManyToOne(targetEntity=order::class, inversedBy="vouchers")
     * @ORM\JoinColumn(nullable=false)
     */
    private Order $order;

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function setOrder(Order $order): self
    {
        $this->order = $order;

        return $this;
    }
}
