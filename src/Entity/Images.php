<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImagesRepository::class)
 */
class Images
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity=Articles::class, inversedBy="images")
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity=RetourExp::class, inversedBy="images")
     */
    private $retourExp;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImages(): ?string
    {
        return $this->images;
    }

    public function setImages(?string $images): self
    {
        $this->images = $images;

        return $this;
    }

    public function getArticle(): ?Articles
    {
        return $this->article;
    }

    public function setArticle(?Articles $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getRetourExp(): ?RetourExp
    {
        return $this->retourExp;
    }

    public function setRetourExp(?RetourExp $retourExp): self
    {
        $this->retourExp = $retourExp;

        return $this;
    }
}
