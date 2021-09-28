<?php

namespace App\Entity;

use App\Repository\AbonnementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AbonnementRepository::class)
 */
class Abonnement {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

/**
     * @ORM\OneToMany(targetEntity=User::class,mappedBy="abonnement" )
     */
    private $User;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $status;

    public function __toString(){
        return $this->getTitle();
    }

    public function getId():?int {
        return $this->id;
    }
   
    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title){
        $this->title = $title;
        return $this;
    }

    public function getPrice():?float {
        return $this->price;
    }
    public function setPrice(float $price):self  {
        $this->price = $price;
        return $this;
    }

    public function getDescription():?string {
        return $this->description;
    }
    public function setDescription(string $description): self {
        $this->description = $description;
        return $this;
    }

    public function getCreatedAt():?\DateTimeInterface {
        return $this->createdAt;
    }
    public function setCreatedAt(\DateTimeInterface $createdAt):self {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getStatus():?\DateTimeInterface {
        return $this->status;
    }
    public function setStatus(\DateTimeInterface $status):self {
        $this->status = $status;
        return $this;
    }
}
