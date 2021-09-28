<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdresseRepository::class)
 */
class Adresse {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\Length(min=1, minMessage="Le numéro de rue doit faire plus de 1 caractères !", allowEmptyString=false,
     * max=10, maxMessage="Le numéro de rue doit faire moins de 10 caractères !")
     */
    private $numeroRue;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(min=3, minMessage="Le nom de la rue doit faire plus de 3 caractères !", allowEmptyString=false,
     * max=50, maxMessage="Le nom de la rue doit faire moins de 50 caractères !")
     */
    private $nomRue;

    /**
     * @ORM\Column(type="string", length=5)
     * @Assert\NotBlank(message="vous devez renseigner votre code postal")
     * @Assert\Length(min=5, minMessage="Le code postal doit se composer de 5 chiffres !", allowEmptyString=false,
     * max=5, maxMessage="Le code postal doit se composer de 5 chiffres !")
     */
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="vous devez renseigner votre ville")
     * @Assert\Length(min=3, minMessage="Nom de ville obligatoire", allowEmptyString=false,
     * max=50, maxMessage="La ville doit faire moins de 50 caractères !")
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(min=3, minMessage="Nom de région obligatoire", allowEmptyString=false,
     * max=50, maxMessage="La région doit faire moins de 30 caractères !")
     */
    private $region;
    
    /**
     * @ORM\OneToMany(targetEntity=Entreprise::class, mappedBy="adresse")
     */
    private $entreprise;

    public function __construct() {
        $this->users = new ArrayCollection();
        $this->entreprise = new ArrayCollection();
    }

    public function getId():?int {
        return $this->id;
    }

    public function getNumeroRue():?string {
        return $this->numeroRue;
    }
    public function setNumeroRue(string $numeroRue):self {
        $this->numeroRue = $numeroRue;
        return $this;
    }

    public function getNomRue():?string {
        return $this->nomRue;
    }
    public function setNomRue(string $nomRue):self {
        $this->nomRue = $nomRue;
        return $this;
    }

    public function getCodePostal():?string {
        return $this->codePostal;
    }
    public function setCodePostal(string $codePostal):self {
        $this->codePostal = $codePostal;
        return $this;
    }

    public function getVille():?string {
        return $this->ville;
    }
    public function setVille(string $ville):self {
        $this->ville = $ville;
        return $this;
    }

    public function getRegion():?string {
        return $this->region;
    }
    public function setRegion(string $region):self {
        $this->region = $region;
        return $this;
    }


    /**
     * @return Collection|Entreprise[]
     */
    public function getentreprise():Collection {
        return $this->entreprise;
    }
    public function addEntreprise(Entreprise $entreprise):self {
        if (!$this->entreprise->contains($entreprise)) {
            $this->entreprise[] = $entreprise;
            $entreprise->setAdresse($this);
        }
        return $this;
    }
    public function removeEntreprise(Entreprise $entreprise):self {
        if ($this->entreprise->contains($entreprise)) {
            $this->entreprise->removeElement($entreprise);
            // set the owning side to null (unless already changed)
            if ($entreprise->getAdresse() === $this) {
                $entreprise->setAdresse(null);
            }
        }
        return $this;
    }
}
