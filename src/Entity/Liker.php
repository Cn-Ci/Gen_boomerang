<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LikerRepository;

/**
 * @ORM\Entity(repositoryClass=LikerRepository::class)
 */
class Liker {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="likers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=articles::class, inversedBy="likers")
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity=RetourExp::class, inversedBy="likers")
     */
    private $retourExp;

    public function getId():?int {
        return $this->id;
    }

    public function getUser():?user {
        return $this->user;
    }
    public function setUser(?user $user):self {
        $this->user = $user;
        return $this;
    }

    public function getArticle():?articles {
        return $this->article;
    }
    public function setArticle(?articles $article):self {
        $this->article = $article;
        return $this;
    }

    public function getRetourExp():?RetourExp {
        return $this->retourExp;
    }
    public function setRetourExp(?RetourExp $retourExp):self {
        $this->retourExp = $retourExp;
        return $this;
    }
}
