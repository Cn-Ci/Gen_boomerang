<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\RetourExpRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=RetourExpRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 * fields={"titrePublication"},
 * message="un autre publication possède déjà ce titre, merci de le modifier"
 * )
 */
class RetourExp {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $titrePublication;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
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
    private $updatedAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rating;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="retourExp", orphanRemoval=true)
     */
    private $commentaire;

    /**
     * @ORM\OneToMany(targetEntity=Liker::class, mappedBy="retourExp", orphanRemoval=true)
     */
    private $likers;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="retourExps")
     * @ORM\JoinColumn(nullable=true)
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity=Images::class, mappedBy="retourExp", orphanRemoval=true, cascade={"persist"})
     */
    private $images;

    /**
     * @ORM\OneToOne(targetEntity=Image::class, mappedBy="imgRetourExp", cascade={"persist", "remove"})
     */
    private $imgRetourExp;

    /**
     * @ORM\Column(type="integer")
     */
    private $views = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $likes = 0;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="retourExpLiked")
     */
    private $usersLikers;

    public function __construct() {
        $this->createdAt   = new \DateTime();
        $this->updatedAt   = new \DateTime();
        $this->commentaire = new ArrayCollection();
        $this->likers      = new ArrayCollection();
        $this->images      = new ArrayCollection();
        $this->usersLikers = new ArrayCollection();
    }

    public function __toString() {
        return $this->getId(). ' - ' . $this->getTitrePublication() ;
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
            $this->slug = $slugify->slugify($this->titrePublication);
        }
    }

    /**
     * Permet d'obtenir la moyenne globale des notes pour cette annonce
     *
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

    public function getId():?int {
        return $this->id;
    }

    public function getTitrePublication():?string {
        return $this->titrePublication;
    }
    public function setTitrePublication(string $titrePublication):self {
        $this->titrePublication = $titrePublication;
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
    public function setSlug(string $slug):self{
        $this->slug = $slug;
        return $this;
    }

    public function getIntro():?string {
        return $this->intro;
    }
    public function setIntro(?string $intro):self {
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
    public function setCreatedAt(?\DateTimeInterface $createdAt):self {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt():?\DateTimeInterface {
        return $this->updatedAt;
    }
    public function setUpdatedAt(?\DateTimeInterface $updatedAt):self {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getRating():?int {
        return $this->rating;
    }
    public function setRating(?int $rating):self {
        $this->rating = $rating;
        return $this;
    }

    public function getLikes():?int {
        return $this->likes;
    }
    public function setLikes(int $likes):self {
        $this->likes = $likes;
        return $this;
    }

    public function getViews():?int {
        return $this->views;
    }
    public function setViews(int $views):self {
        $this->views = $views;
        return $this;
    }

    /**
     * @return Collection|commentaire[]
     */
    public function getCommentaire():Collection {
        return $this->commentaire;
    }
    public function addCommentaire(commentaire $commentaire):self {
        if (!$this->commentaire->contains($commentaire)) {
            $this->commentaire[] = $commentaire;
            $commentaire->setRetourExp($this);
        }

        return $this;
    }
    public function removeCommentaire(commentaire $commentaire):self {
        if ($this->commentaire->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getRetourExp() === $this) {
                $commentaire->setRetourExp(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Liker[]
     */
    public function getLikers():Collection {
        return $this->likers;
    }
    public function addLiker(Liker $liker):self {
        if (!$this->likers->contains($liker)) {
            $this->likers[] = $liker;
            $liker->setRetourExp($this);
        }

        return $this;
    }
    public function removeLiker(Liker $liker):self {
        if ($this->likers->removeElement($liker)) {
            // set the owning side to null (unless already changed)
            if ($liker->getRetourExp() === $this) {
                $liker->setRetourExp(null);
            }
        }
        return $this;
    }

    public function getAuthor():?User {
        return $this->author;
    }
    public function setAuthor(?User $author):self {
        $this->author = $author;
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
            $image->setRetourExp($this);
        }

        return $this;
    }
    public function removeImage(Images $image):self {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getRetourExp() === $this) {
                $image->setRetourExp(null);
            }
        }
        return $this;
    }

    public function getImgRetourExp():?Image {
        return $this->imgRetourExp;
    }
    public function setImgRetourExp(?Image $imgRetourExp):self {
        // unset the owning side of the relation if necessary
        if ($imgRetourExp === null && $this->imgRetourExp !== null) {
            $this->imgRetourExp->setImgRetourExp(null);
        }

        // set the owning side of the relation if necessary
        if ($imgRetourExp !== null && $imgRetourExp->getImgRetourExp() !== $this) {
            $imgRetourExp->setImgRetourExp($this);
        }
        $this->imgRetourExp = $imgRetourExp;
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
        }
        return $this;
    }
    public function removeUsersLiker(User $usersLiker):self {
        $this->usersLikers->removeElement($usersLiker);
        return $this;
    }
}
