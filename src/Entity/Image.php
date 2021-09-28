<?php

namespace App\Entity;

use App\Repository\ImageProfilRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageProfilRepository::class)
 */
class Image
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
    private $titre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageArt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageRExp;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $userAvatar;

    /**
     * @ORM\OneToOne(targetEntity=RetourExp::class, inversedBy="imgRetourExp", cascade={"persist", "remove"})
     */
    private $imgRetourExp;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="imgUserAvatar", cascade={"persist", "remove"})
     */
    private $imgUserAvatar;

    /**
     * @ORM\OneToOne(targetEntity=Articles::class, inversedBy="imgArticle", cascade={"persist", "remove"})
     */
    private $imgArticle;

    public function __toString() {
        return $this->getId(). ' - ' .$this->getTitre() ;
    }

    public function getId():?int {
        return $this->id;
    }

    public function getTitre() {
        return $this->titre;
    }
    public function setTitre($titre) {
        $this->titre = $titre;
        return $this;
    }

    public function getImageArt():?string {
        return $this->imageArt;
    }
    public function setImageArt(?string $imageArt):self {
        $this->imageArt = $imageArt;
        return $this;
    }

    public function getImageRExp() {
        return $this->imageRExp;
    }
    public function setImageRExp($imageRExp) {
        $this->imageRExp = $imageRExp;
        return $this;
    }
 
    public function getUserAvatar(){
        return $this->userAvatar;
    }
    public function setUserAvatar($userAvatar) {
        $this->userAvatar = $userAvatar;
        return $this;
    }

    public function getImgRetourExp():?RetourExp {
        return $this->imgRetourExp;
    }
    public function setImgRetourExp(?RetourExp $imgRetourExp):self {
        $this->imgRetourExp = $imgRetourExp;
        return $this;
    }

    public function getImgUserAvatar():?User {
        return $this->imgUserAvatar;
    }
    public function setImgUserAvatar(?User $imgUserAvatar):self {
        $this->imgUserAvatar = $imgUserAvatar;
        return $this;
    }

    public function getImgArticle():?Articles {
        return $this->imgArticle;
    }
    public function setImgArticle(?Articles $imgArticle):self {
        $this->imgArticle = $imgArticle;
        return $this;
    }
}
