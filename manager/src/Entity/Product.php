<?php
declare(strict_types=1);

namespace App\Entity;

use App\Trait\Entity\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="code", columns={"code"})})
 * @ORM\Entity
 *
 * @ORM\HasLifecycleCallbacks
 */
class Product
{
    use TimestampableTrait;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private string $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $description;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10, nullable=false)
     */
    private string $code;

    /**
     * @ORM\Column(type="integer")
     */
    private $stockLevel;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTime $discontinuedAt;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getDiscontinuedAt(): ?\DateTimeInterface
    {
        return $this->discontinuedAt;
    }

    public function setDiscontinuedAt(?\DateTimeInterface $discontinuedAt): self
    {
        $this->discontinuedAt = $discontinuedAt;

        return $this;
    }

    public function getStockLevel(): ?int
    {
        return $this->stockLevel;
    }

    public function setStockLevel(int $stockLevel): self
    {
        $this->stockLevel = $stockLevel;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }
}
