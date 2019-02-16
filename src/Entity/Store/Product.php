<?php

namespace App\Entity\Store;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Store\ProductRepository")
 * @ORM\Table(name="sto_product")
 */
class Product
{
    const IMAGE_PUBLIC_DIR = 'img/products/';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Store\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false, name="sto_image_id")
     */
    private $image;

    /**
     * @ORM\Column(type="text")
     */
    private $description_longue;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Store\Brand", inversedBy="products")
     * @ORM\JoinColumn(nullable=false, name="sto_brand_id")
     */
    private $brand;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Store\Color")
     * @ORM\JoinTable(name="product_color")
     */
    private $Color;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Store\Opinion", inversedBy="products")
     * @ORM\JoinTable(name="product_opinion")
     */
    private $opinions;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->Color = new ArrayCollection();
        $this->opinions = new ArrayCollection();
    }

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

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDescriptionLongue(): ?string
    {
        return $this->description_longue;
    }

    public function setDescriptionLongue(string $description_longue): self
    {
        $this->description_longue = $description_longue;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getImagePublicPath()
    {
        return self::IMAGE_PUBLIC_DIR.$this->getImage()->getUrl();
    }

    /**
     * @return Collection|Color[]
     */
    public function getColor(): Collection
    {
        return $this->Color;
    }

    public function addColor(Color $color): self
    {
        if (!$this->Color->contains($color)) {
            $this->Color[] = $color;
        }

        return $this;
    }

    public function removeColor(Color $color): self
    {
        if ($this->Color->contains($color)) {
            $this->Color->removeElement($color);
        }

        return $this;
    }

    /**
     * @return Collection|Opinion[]
     */
    public function getOpinions(): Collection
    {
        return $this->opinions;
    }

    public function addOpinion(Opinion $opinion): self
    {
        if (!$this->opinions->contains($opinion)) {
            $this->opinions[] = $opinion;
        }

        return $this;
    }

    public function removeOpinion(Opinion $opinion): self
    {
        if ($this->opinions->contains($opinion)) {
            $this->opinions->removeElement($opinion);
        }

        return $this;
    }
}
