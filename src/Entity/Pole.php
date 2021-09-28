<?php

namespace App\Entity;

use App\Repository\PoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PoleRepository::class)
 */
class Pole
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomPole;
    

    /**
     * @ORM\OneToMany(targetEntity=FaQuestions::class, mappedBy="pole")
     */
    private $faQuestions;

    /**
     * @ORM\OneToMany(targetEntity=SecteurActivite::class, mappedBy="pole")
     */
    private $secteurActivites;

    /**
     * @ORM\OneToMany(targetEntity=UserNewsletter::class, mappedBy="pole")
     */
    private $newsletters;

    //--- a voir si necessaire 19.07.21
      /**
     * @ORM\ManyToMany(targetEntity=UserNewsletter::class, mappedBy="pole")
     */
    private $userNewsletter;

    
    public function __construct()
    {
        $this->faQuestions = new ArrayCollection();
        $this->secteurActivites = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nomPole ;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPole(): ?string
    {
        return $this->nomPole;
    }

    public function setNomPole(string $nomPole): self
    {
        $this->nomPole = $nomPole;
        return $this;
    }

    /**
     * @return Collection|FaQuestions[]
     */
    public function getFaQuestions(): Collection
    {
        return $this->faQuestions;
    }

    public function addFaQuestion(FaQuestions $faQuestion): self
    {
        if (!$this->faQuestions->contains($faQuestion)) {
            $this->faQuestions[] = $faQuestion;
            $faQuestion->setPole($this);
        }

        return $this;
    }

    public function removeFaQuestion(FaQuestions $faQuestion): self
    {
        if ($this->faQuestions->removeElement($faQuestion)) {
            // set the owning side to null (unless already changed)
            if ($faQuestion->getPole() === $this) {
                $faQuestion->setPole(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SecteurActivite[]
     */
    public function getSecteurActivites(): Collection
    {
        return $this->secteurActivites;
    }

    public function addSecteurActivite(SecteurActivite $secteurActivite): self
    {
        if (!$this->secteurActivites->contains($secteurActivite)) {
            $this->secteurActivites[] = $secteurActivite;
            $secteurActivite->setPole($this);
        }

        return $this;
    }

    public function removeSecteurActivite(SecteurActivite $secteurActivite): self
    {
        if ($this->secteurActivites->removeElement($secteurActivite)) {
            // set the owning side to null (unless already changed)
            if ($secteurActivite->getPole() === $this) {
                $secteurActivite->setPole(null);
            }
        }

        return $this;
    }
}