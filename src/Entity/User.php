<?php
// src/Entity/User.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City", inversedBy="users")
     * @ORM\JoinColumn(nullable=true)
     */
    private $city;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="user")
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Buy", mappedBy="user")
     */
    private $buys;

    public function __construct()
    {
        parent::__construct();
        $this->products = new ArrayCollection();
        $this->buys = new ArrayCollection();
        // your own logic
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

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setUser($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getUser() === $this) {
                $product->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Buy[]
     */
    public function getBuys(): Collection
    {
        return $this->buys;
    }

    public function addBuy(Buy $buy): self
    {
        if (!$this->buys->contains($buy)) {
            $this->buys[] = $buy;
            $buy->setUser($this);
        }

        return $this;
    }

    public function removeBuy(Buy $buy): self
    {
        if ($this->buys->contains($buy)) {
            $this->buys->removeElement($buy);
            // set the owning side to null (unless already changed)
            if ($buy->getUser() === $this) {
                $buy->setUser(null);
            }
        }

        return $this;
    }
}