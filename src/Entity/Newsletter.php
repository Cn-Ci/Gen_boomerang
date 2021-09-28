<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\NewsletterRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=NewsletterRepository::class)
 */
class Newsletter {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titleOne;

  
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titleTwo;



    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity=Pole::class, inversedBy="newsletters")
     */
    private $pole;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descOne;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descTwo;

    public function __construct() {
        $this->abonne = new ArrayCollection();
        $this->created_at = new \DateTime();
    }

    public function __toString() {
        return $this->titleOne;
    }

    public function getId():?int {
        return $this->id;
    }

    public function getTitleOne():?string {
        return $this->titleOne;
    }
    public function setTitleOne(string $titleOne):self {
        $this->titleOne = $titleOne;
        return $this;
    }

    public function getTitleTwo():?string {
        return $this->titleTwo;
    }
    public function setTitleTwo(?string $titleTwo):self {
        $this->titleTwo = $titleTwo;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getPole(): ?Pole
    {
        return $this->pole;
    }

    public function setPole(?Pole $pole): self
    {
        $this->pole = $pole;

        return $this;
    }

    public function getDescOne(): ?string
    {
        return $this->descOne;
    }

    public function setDescOne(?string $descOne): self
    {
        $this->descOne = $descOne;

        return $this;
    }

    public function getDescTwo(): ?string
    {
        return $this->descTwo;
    }

    public function setDescTwo(?string $descTwo): self
    {
        $this->descTwo = $descTwo;

        return $this;
    }

}