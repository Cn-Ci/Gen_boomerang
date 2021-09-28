<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $contenu;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $rating;

    /**
     * @ORM\ManyToOne(targetEntity=Articles::class, inversedBy="commentaire")
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity=RetourExp::class, inversedBy="commentaire")
     */
    private $retourExp;
    
    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commentaire")
     */
    private $userCommentaire;


    public function __toString()
    {
        return $this->contenu ;
    }

    public function getId():?int {
        return $this->id;
    }

    public function getContenu():?string {
        return $this->contenu;
    }
    public function setContenu(string $contenu):self {
        $this->contenu = $contenu;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface {
        return $this->createdAt;
    }
    public function setCreatedAt(\DateTimeInterface $createdAt):self {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getArticle():?Articles {
        return $this->article;
    }
    public function setArticle(?Articles $article): self {
        $this->article = $article;
        return $this;
    }

    public function getUserCommentaire():?User {
        return $this->userCommentaire;
    }
    public function setUserCommentaire(?User $userCommentaire):self {
        $this->userCommentaire = $userCommentaire;
        return $this;
    }

    public function getRetourExp(): ?RetourExp{
        return $this->retourExp;
    }
    public function setRetourExp(?RetourExp $retourExp): self{
        $this->retourExp = $retourExp;
        return $this;
    }

    public function getRating(){
        return $this->rating;
    }
    public function setRating($rating){
        $this->rating = $rating;
        return $this;
    }
}
