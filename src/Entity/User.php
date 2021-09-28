<?php

namespace App\Entity;

use Serializable;
use App\Entity\Message;
use App\Entity\Articles;
use App\Entity\Document;
use App\Entity\Abonnement;
use App\Entity\Commentaire;
use App\Entity\Participant;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"email"}, message="cette adresse email existe déjà")
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="type", type="string")
 * @DiscriminatorMap({"sansEmploi" = "SansEmploi", "etudiant" = "Etudiant", "salarie" = "Salarie", "retraite" = "Retraite", "professionLiberale" = "ProfessionLiberale", "entrepreneur" = "Entrepreneur"})
 */
abstract class User implements UserInterface, \Serializable {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="Vous devez renseigner votre email")
     * @Assert\Email(message="Veuillez renseigner un email valide !")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez renseigner un mot de passe")
     * @Assert\Regex(
     *    pattern     = "#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{6,}$#",
     *    htmlPattern = "#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{6,}$#",
     * )
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="Vous n'avez pas correctement confirmé votre mot de passe ")
     */
    public $passwordConfirm;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="vous devez renseigner votre prénom")
     * @Assert\Length(min=2, minMessage="Minimum 2 caractères pour le prénom", allowEmptyString=false,
     * max=50, maxMessage="le prénom est trop long (pas plus de 50 caractères)")
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Votre prénom ne doit pas contenir de chiffre"
     * )
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="vous devez renseigner votre nom")
     * @Assert\Length(min=2, minMessage="Minimum 2 caractères pour le nom", allowEmptyString=false,
     * max=50, maxMessage="le nom est trop long (pas plus de 50 caractères)")
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Votre nom ne doit pas contenir de chiffre"
     * )
     */
    private $lastName;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $civilite;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthdate;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Articles::class, mappedBy="author", orphanRemoval=true)
     */
    private $articles;

    /**
     * @ORM\ManyToOne(targetEntity=Abonnement::class, cascade={"persist", "remove"})
     */
    private $abonnement;

    /**
     * @ORM\OneToMany(targetEntity=Document::class, mappedBy="user", orphanRemoval=true, cascade={"persist"} )
     */
    private $documents;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="user")
     */
    private $messages;

     /**
     * @ORM\OneToMany(targetEntity="Participant", mappedBy="user")
     */
    private $participants;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="userCommentaire")
     */
    private $commentaire;

    /**
     * @ORM\OneToMany(targetEntity=RetourExp::class, mappedBy="author")
     */
    private $retourExps;

    /**
     * @ORM\OneToOne(targetEntity=Image::class, mappedBy="imgUserAvatar", cascade={"persist", "remove"})
     */
    private $imgUserAvatar;

    /**
     * @ORM\OneToMany(targetEntity=FaQuestions::class, mappedBy="author")
     */
    private $faQuestions;

    /**
     * @ORM\OneToMany(targetEntity=SecteurActivite::class, mappedBy="author")
     */
    private $secteurActivites;

    /**
     * @ORM\ManyToMany(targetEntity=Articles::class, inversedBy="usersLikers")
     */
    private $likes;

    /**
     * @ORM\ManyToMany(targetEntity=RetourExp::class, mappedBy="usersLikers")
     */
    private $retourExpLiked;

   

    /**
     * @ORM\OneToMany(targetEntity=Notification::class, mappedBy="userNotifs")
     */
    private $notif;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isSubToNews = 0;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reset_token;

    public function __toString() {
        return $this->getId(). ' - ' .$this->getFirstName(). ' - ' .$this->getLastName() ;
    }

    public function __construct() {
        $this->articles         = new ArrayCollection();
        $this->messages         = new ArrayCollection();
        $this->documents        = new ArrayCollection();
        $this->retourExps       = new ArrayCollection();
        $this->faQuestions      = new ArrayCollection();
        $this->commentaire      = new ArrayCollection();
        $this->participants     = new ArrayCollection();
        $this->secteurActivites = new ArrayCollection();
        $this->likes            = new ArrayCollection();
        $this->retourExpLiked   = new ArrayCollection();
        $this->notif            = new ArrayCollection();
    }

    public function serialize() {
        return serialize(array(
        $this->id,
        $this->email,
        $this->password,
        ));
    }
    public function unserialize($serialized) {
        list (
            $this->id,
            $this->email,
            $this->password,
        ) = unserialize($serialized);
    }

    /**
     * A visual identifier that represents this user.
     * @see UserInterface
     */
    public function getUsername():string {
        return (string) $this->email;
    }

    public function getFullName() {
        return "{$this->firstName} {$this->lastName}";
    }

    public function getId():?int {
        return $this->id;
    }

    public function getEmail():?string {
        return $this->email;
    }
    public function setEmail(string $email):self {
        $this->email = $email;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles():array {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }
    public function setRoles(array $roles):self {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword():string {
        return (string) $this->password;
    }
    public function setPassword(string $password):self {
        $this->password = $password;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt() {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials() {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * Set the value of VerifyPassword
     * @return self
     */ 
    public function setVerifyPassword($VerifyPassword) {
        $this->VerifyPassword = $VerifyPassword;
        return $this;
    }

    public function getFirstName():?string {
        return $this->firstName;
    }
    public function setFirstName(string $firstName):self {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName():?string {
        return $this->lastName;
    }
    public function setLastName(string $lastName):self {
        $this->lastName = $lastName;
        return $this;
    }

    public function isVerified():bool {
        return $this->isVerified;
    }
    public function setIsVerified(bool $isVerified):self {
        $this->isVerified = $isVerified;
        return $this;
    }

    /**
     * @return Collection|Articles[]
     */
    public function getArticles():Collection {
        return $this->articles;
    }
    public function addArticle(Articles $article):self {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setAuthor($this);
        }
        return $this;
    }
    public function removeArticle(Articles $article):self {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getAuthor() === $this) {
                $article->setAuthor(null);
            }
        }
        return $this;
    }

    public function getUpdatedAt():?\DateTimeInterface {
        return $this->updated_at;
    }
    public function setUpdatedAt(\DateTimeInterface $updated_at):self {
        $this->updated_at = $updated_at;
        return $this;
    }

    public function getTelephone():?string {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone):self {
        $this->telephone = $telephone;
        return $this;
    }
    
    public function getCivilite():?string {
        return $this->civilite;
    }
    
    public function setCivilite(string $civilite):self {
        $this->civilite = $civilite;
        return $this;
    }
    
    public function getBirthdate():?\DateTimeInterface {
        return $this->birthdate;
    }
    public function setBirthdate(?\DateTimeInterface $birthdate):self {
        $this->birthdate = $birthdate;
        return $this;
    }
    
    public function getDescription():?string {
        return $this->description;
    }
    public function setDescription(?string $description):self {
        $this->description = $description;
        return $this;
    }

    public function getAbonnement():?Abonnement {
        if($this->abonnement == true){
            $roles = ["ROLE_ABONNE"];
        }else{
            $roles = ["ROLE_USER"];
        }
        return $this->abonnement;
    }
    public function setAbonnement(Abonnement $abonnement):self {
        $this->abonnement = $abonnement;
        return $this;
    }

    /**
     * @return Collection|Document[]
     */
    public function getDocuments(){
        return $this->documents;
    }
    public function addDocument(Document $document):self {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setUser($this);
        }
        return $this;
    }
    public function removeDocument(Document $document):self {
        if ($this->documents->contains($document)) {
            $this->documents->removeElement($document);
            // set the owning side to null (unless already changed)
            if ($document->getUser() === $this) {
                $document->setUser(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages():Collection {
        return $this->messages;
    }
    public function addMessage(Message $message):self {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setUser($this);
        }
        return $this;
    }
    public function removeMessage(Message $message):self {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getUser() === $this) {
                $message->setUser(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|Participant[]
     */
    public function getParticipants():Collection {
        return $this->participants;
    }
    public function addParticipant(Participant $participant): self {
        if (!$this->participants->contains($participant)) {
            $this->participants[] = $participant;
            $participant->setUser($this);
        }
        return $this;
    }
    public function removeParticipant(Participant $participant): self {
        if ($this->participants->contains($participant)) {
            $this->participants->removeElement($participant);
            // set the owning side to null (unless already changed)
            if ($participant->getUser() === $this) {
                $participant->setUser(null);
            }
        }
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
            $commentaire->setUserCommentaire($this);
        }
        return $this;
    }
    public function removeCommentaire(Commentaire $commentaire):self {
        if ($this->commentaire->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getUserCommentaire() === $this) {
                $commentaire->setUserCommentaire(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|RetourExp[]
     */
    public function getRetourExps():Collection {
        return $this->retourExps;
    }
    public function addRetourExp(RetourExp $retourExp):self {
        if (!$this->retourExps->contains($retourExp)) {
            $this->retourExps[] = $retourExp;
            $retourExp->setAuthor($this);
        }
        return $this;
    }
    public function removeRetourExp(RetourExp $retourExp):self {
        if ($this->retourExps->removeElement($retourExp)) {
            // set the owning side to null (unless already changed)
            if ($retourExp->getAuthor() === $this) {
                $retourExp->setAuthor(null);
            }
        }
        return $this;
    }

    public function getImgUserAvatar():?Image {
        return $this->imgUserAvatar;
    }
    public function setImgUserAvatar(?Image $imgUserAvatar):self {
        // unset the owning side of the relation if necessary
        if ($imgUserAvatar === null && $this->imgUserAvatar !== null) {
            $this->imgUserAvatar->setImgUserAvatar(null);
        }

        // set the owning side of the relation if necessary
        if ($imgUserAvatar !== null && $imgUserAvatar->getImgUserAvatar() !== $this) {
            $imgUserAvatar->setImgUserAvatar($this);
        }

        $this->imgUserAvatar = $imgUserAvatar;

        return $this;
    }

    /**
     * @return Collection|FaQuestions[]
     */
    public function getFaQuestions():Collection {
        return $this->faQuestions;
    }
    public function addFaQuestion(FaQuestions $faQuestion):self {
        if (!$this->faQuestions->contains($faQuestion)) {
            $this->faQuestions[] = $faQuestion;
            $faQuestion->setAuthor($this);
        }
        return $this;
    }
    public function removeFaQuestion(FaQuestions $faQuestion):self {
        if ($this->faQuestions->removeElement($faQuestion)) {
            // set the owning side to null (unless already changed)
            if ($faQuestion->getAuthor() === $this) {
                $faQuestion->setAuthor(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|SecteurActivite[]
     */
    public function getSecteurActivites():Collection {
        return $this->secteurActivites;
    }
    public function addSecteurActivite(SecteurActivite $secteurActivite):self {
        if (!$this->secteurActivites->contains($secteurActivite)) {
            $this->secteurActivites[] = $secteurActivite;
            $secteurActivite->setAuthor($this);
        }
        return $this;
    }
    public function removeSecteurActivite(SecteurActivite $secteurActivite):self {
        if ($this->secteurActivites->removeElement($secteurActivite)) {
            // set the owning side to null (unless already changed)
            if ($secteurActivite->getAuthor() === $this) {
                $secteurActivite->setAuthor(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|Articles[]
     */
    public function getLikes():Collection {
        return $this->likes;
    }
    public function addLike(Articles $like):self {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
        }
        return $this;
    }
    public function removeLike(Articles $like):self {
        $this->likes->removeElement($like);
        return $this;
    }

    /**
     * @return Collection|RetourExp[]
     */
    public function getRetourExpLiked(): Collection {
        return $this->retourExpLiked;
    }
    public function addRetourExpLiked(RetourExp $retourExpLiked):self {
        if (!$this->retourExpLiked->contains($retourExpLiked)) {
            $this->retourExpLiked[] = $retourExpLiked;
            $retourExpLiked->addUsersLiker($this);
        }
        return $this;
    }
    public function removeRetourExpLiked(RetourExp $retourExpLiked): self {
        if ($this->retourExpLiked->removeElement($retourExpLiked)) {
            $retourExpLiked->removeUsersLiker($this);
        }
        return $this;
    }

    /**
     * @return Collection|Notification[]
     */
    public function getNotif(): Collection {
        return $this->notif;
    }
    public function addNotif(Notification $notif):self {
        if (!$this->notif->contains($notif)) {
            $this->notif[] = $notif;
            $notif->setUserNotifs($this);
        }
        return $this;
    }
    public function removeNotif(Notification $notif):self {
        if ($this->notif->removeElement($notif)) {
            // set the owning side to null (unless already changed)
            if ($notif->getUserNotifs() === $this) {
                $notif->setUserNotifs(null);
            }
        }
        return $this;
    }

    public function getIsSubToNews(): ?bool
    {
        return $this->isSubToNews;
    }

    public function setIsSubToNews(bool $isSubToNews): self
    {
        $this->isSubToNews = $isSubToNews;

        return $this;
    }

    public function getResetToken(): ?string
    {
        return $this->reset_token;
    }

    public function setResetToken(?string $reset_token): self
    {
        $this->reset_token = $reset_token;

        return $this;
    }
}