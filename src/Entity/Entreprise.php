<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=EntrepriseRepository::class)
 */
class Entreprise {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $activite;

    /**
     * @ORM\ManyToOne(targetEntity=Adresse::class, inversedBy="entreprises", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $adresse;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="entreprise")
     */
    private $user;

    public function __construct() {
        $this->user = new ArrayCollection();
    }

    public function __toString() {
        return $this->getNom();
    }

    public function getId():?int {
        return $this->id;
    }

    public function getNom():?string {
        return $this->nom;
    }
    public function setNom(string $nom):self {
        $this->nom = $nom;
        return $this;
    }

    public function getActivite():?string {
        return $this->activite;
    }
    public function setActivite(string $activite):self {
        $this->activite = $activite;
        return $this;
    }

    public function getAdresse():?Adresse {
        return $this->adresse;
    }
    public function setAdresse(?Adresse $adresse):self {
        $this->adresse = $adresse;
        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser():Collection {
        return $this->user;
    }
    public function addUser(User $user):self {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setEntreprise($this);
        }
        return $this;
    }
    public function removeUser(User $user):self {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getEntreprise() === $this) {
                $user->setEntreprise(null);
            }
        }
        return $this;
    }
}
