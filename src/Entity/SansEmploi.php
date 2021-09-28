<?php

namespace App\Entity;

use App\Repository\SansEmploiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SansEmploiRepository::class)
 */
class SansEmploi extends User {

    /**
     * @ORM\Column(type="string", length=255, nullable=true, nullable=true)
     */
    private $searchedJob;

     /**
     * @ORM\OneToMany(targetEntity=Document::class, mappedBy="user", orphanRemoval=true, cascade={"persist"} )
     */
    private $documents;

    public function __construct() {
        $this->documents = new ArrayCollection();        
    }

    public function getId():?int {
        return parent::getId();
    }

    public function getType():string {
        return 'Sans Emploi';
    }
    public function getTypeWithoutSpecialChart():String {
        return 'sansEmploi';
    }

    public function getImage(){
        return parent::getAvatar();
    }

    public function getSearchedJob():?string {
        return $this->searchedJob;
    }
    public function setSearchedJob(?string $searchedJob):self {
        $this->searchedJob = $searchedJob;
        return $this;
    }

    /**
     * @return Collection|Document[]
     */
    public function getDocuments() {
        return $this->documents;
    }

    public function addDocument(Document $document):self {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setSansEmploieDocument($this);
        }
        return $this;
    }

    public function removeDocument(Document $document):self {
        if ($this->documents->contains($document)) {
            $this->documents->removeElement($document);
            // set the owning side to null (unless already changed)
            if ($document->getSansEmploieDocument() === $this) {
                $document->setSansEmploieDocument(null);
            }
        }
        return $this;
    }
    
}
