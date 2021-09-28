<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use App\Entity\Commentaire;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ArticlesRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ArticlesRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 * fields={"titreArticle"},
 * message="un autre article possède déjà ce titre, merci de le modifier"
 * ) 
 */
class Articles {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=50)
     * 
     *
     */
    private $titreArticle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     */
    private $accroche;

    /**
     * @ORM\Column(type="string", length=255)
     */ 
    private $slug;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $intro;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=50, minMessage="Le contenu de l'article doit faire plus de 50 caratères", allowEmptyString=false)
     */
    private $contenu;
      
      /**
     * @ORM\OneToMany(targetEntity=Images::class, mappedBy="article",cascade={"persist"})
     */
    private $images; 

      /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $video;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $UpdatedAt;
    
    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="article", orphanRemoval=true)
     * @ORM\JoinColumn(nullable=true)
     */
    private $commentaire;
    
    /**
     * @ORM\OneToMany(targetEntity=Liker::class, mappedBy="article", orphanRemoval=true)
     */
    private $likers;
    
    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=true)
     */
    private $author;

    /**
     * @ORM\Column(type="integer")
     */
    private $views = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $likes = 0;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="likes")
     */
    private $usersLikers;

    /**
     * @ORM\OneToOne(targetEntity=Image::class, mappedBy="imgArticle", cascade={"persist", "remove"})
     */
    private $imgArticle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pole;

    public function __construct() {
        $this->createdAt    = new \DateTime();
        $this->updatedAt    = new \DateTime();
        $this->likers       = new ArrayCollection();
        $this->images       = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->usersLikers = new ArrayCollection();
    }

    public function __toString() {
        return $this->getId(). ' - ' . $this->getTitreArticle() ;
    }

    /**
     * permet d'initialiser le slug
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * 
     * @return  void
     */
    public function initializeSlug() {
        if(empty($this->slug)) {
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->titreArticle);
        }
    }

    /**
     * Permet d'obtenir la moyenne globale des notes pour cette annonce
     * @return float
     */
    public function getAvgRatings() {
        // Calculer la somme des notations
        $sum = array_reduce($this->commentaire->toArray(), function($total, $commentaire) {
            return $total + $commentaire->getRating();
        }, 0);

        // Faire la division pour avoir la moyenne
        if(count($this->commentaire) > 0) return $sum / count($this->commentaire);

        return 0;
    }
    
    public function getId(): ?int{
        return $this->id;
    }

    public function getTitreArticle():?string {
        return $this->titreArticle;
    }
    public function setTitreArticle(string $titreArticle):self {
        $this->titreArticle = $titreArticle;
        return $this;
    }

    public function getAccroche():?string {
        return $this->accroche;
    }
    public function setAccroche(?string $accroche):self {
        $this->accroche = $accroche;
        return $this;
    }
    
    public function getSlug():?string {
        return $this->slug;
    }
    public function setSlug(string $slug):self {
        $this->slug = $slug;
        return $this;
    }

    public function getIntro():?string {
        return $this->intro;
    }
    public function setIntro(string $intro):self {
        $this->intro = $intro;
        return $this;
    }

    public function getContenu():?string {
        return $this->contenu;
    }
    public function setContenu(string $contenu):self {
        $this->contenu = $contenu;
        return $this;
    }

    public function getVideo():?string {
        return $this->video;
    }
    public function setVideo(?string $video):self {
        $this->video = $video;
        return $this;
    }
    
    public function getCreatedAt():?\DateTimeInterface {
        return $this->createdAt;
    }
    public function setCreatedAt(\DateTimeInterface $createdAt):self {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt():?\DateTimeInterface {
        return $this->UpdatedAt;
    }
    public function setUpdatedAt(\DateTimeInterface $UpdatedAt):self {
        $this->UpdatedAt = $UpdatedAt;
        return $this;
    }
    
    public function getRating():?int {
        return $this->rating;
    }
    public function setRating(int $rating):self {
        $this->rating = $rating;
        return $this;
    }
    
    public function getAuthor(): ?User{
        return $this->author;
    }
    public function setAuthor(?User $author): self{
        $this->author = $author;
        return $this;
    }
    
    public function getViews():?int {
        return $this->views;
    }
    public function setViews(int $views):self {
        $this->views = $views;
        return $this;
    }

    public function getLikes():?int {
        return $this->likes;
    }
    public function setLikes(int $likes):self {
        $this->likes = $likes;
        return $this;
    }
    
    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaire():Collection {
        return $this->commentaire;
    }
    public function addCommentaire(Commentaire $commentaire):self {
        if (!$this->commentaire->contains($commentaire)) {
            $this->commentaire[] = $commentaire;
            $commentaire->setArticle($this);
        }
        return $this;
    }
    public function removeCommentaire(Commentaire $commentaire):self {
        if ($this->commentaire->contains($commentaire)) {
            $this->commentaire->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getArticle() === $this) {
                $commentaire->setArticle(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|Images[]
     */
    public function getImages():Collection {
        return $this->images;
    }
    public function addImage(Images $image):self {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setArticle($this);
        }
        return $this;
    }
    public function removeImage(Images $image):self {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getArticle() === $this) {
                $image->setArticle(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsersLikers():Collection {
        return $this->usersLikers;
    }
    public function addUsersLiker(User $usersLiker):self {
        if (!$this->usersLikers->contains($usersLiker)) {
            $this->usersLikers[] = $usersLiker;
            $usersLiker->addLike($this);
        }
        return $this;
    }
    public function removeUsersLiker(User $usersLiker):self {
        if ($this->usersLikers->removeElement($usersLiker)) {
            $usersLiker->removeLike($this);
        }
        return $this;
    }

    public function getImgArticle():?Image {
        return $this->imgArticle;
    }
    public function setImgArticle(?Image $imgArticle):self {
        // unset the owning side of the relation if necessary
        if ($imgArticle === null && $this->imgArticle !== null) {
            $this->imgArticle->setImgArticle(null);
        }

        // set the owning side of the relation if necessary
        if ($imgArticle !== null && $imgArticle->getImgArticle() !== $this) {
            $imgArticle->setImgArticle($this);
        }
        $this->imgArticle = $imgArticle;
        return $this;
    }

    public function getPole():?string {
        return $this->pole;
    }
    public function setPole(string $pole):self {
        $this->pole = $pole;
        return $this;
    }
}