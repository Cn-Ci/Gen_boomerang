<?php

namespace App\Entity;

use App\Repository\ImageNewsletterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageNewsletterRepository::class)
 */
class ImageNewsletter
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Newsletter::class, inversedBy="imageNewsletterOne")
     */
    private $imageNewsletterOne;

    /**
     * @ORM\ManyToOne(targetEntity=Newsletter::class, inversedBy="imageNewsletterTwo")
     */
    private $imageNewsletterTwo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageOne(): ?Newsletter
    {
        return $this->imageOne;
    }

    public function setImageOne(?Newsletter $imageOne): self
    {
        $this->imageOne = $imageOne;

        return $this;
    }

    public function getImageNewsletterTwo(): ?Newsletter
    {
        return $this->imageNewsletterTwo;
    }

    public function setImageNewsletterTwo(?Newsletter $imageNewsletterTwo): self
    {
        $this->imageNewsletterTwo = $imageNewsletterTwo;

        return $this;
    }
}
