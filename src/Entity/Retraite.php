<?php

namespace App\Entity;

use App\Repository\RetraiteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RetraiteRepository::class)
 */
class Retraite extends User {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $precedentJobs;
    

    public function getId():?int {
        return parent::getId();
    }

    public function getType():String {
        return 'Retraité';
    }
    public function getTypeWithoutSpecialChart():String {
        return 'retraite';
    }

    public function getImage(){
        return parent::getAvatar();
    }

    public function getPrecedentJobs():?String {
        return $this->precedentJobs;
    }
    public function setPrecedentJobs(?String $precedentJobs): self {
        $this->precedentJobs = $precedentJobs;
        return $this;
    }
}
