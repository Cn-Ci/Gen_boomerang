<?php

namespace App\Entity;

use App\Repository\EtudiantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtudiantRepository::class)
 */
class Etudiant extends User {
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $schoolName;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $lvlOfStudies;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $domainStudies;

    public function getId():?int {
        return parent::getId();
    }
    
    public function getType():string {
        return 'Etudiant';
    }
    public function getTypeWithoutSpecialChart():String {
        return 'etudiant';
    }
    

    public function getImage(){
        return parent::getAvatar();
    }

    public function getSchoolName():?string {
        return $this->schoolName;
    }
    public function setSchoolName(string $schoolName):self {
        $this->schoolName = $schoolName;
        return $this;
    }

    public function getLvlOfStudies():?string {
        return $this->lvlOfStudies;
    }
    public function setLvlOfStudies(string $lvlOfStudies):self {
        $this->lvlOfStudies = $lvlOfStudies;
        return $this;
    }

    public function getDomainStudies():?string {
        return $this->domainStudies;
    }
    public function setDomainStudies(string $domainStudies):self {
        $this->domainStudies = $domainStudies;
        return $this;
    }
}
