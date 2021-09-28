<?php

namespace App\Entity;

use App\Repository\SalarieRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SalarieRepository::class)
 */
class Salarie extends User {
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $currentJob;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyName;


    public function getId():?int {
        return parent::getId();
    }

    public function getType():string {
        return 'Salarié';
    }
    public function getTypeWithoutSpecialChart():String {
        return 'salarie';
    }

    // public function getImage(){
    //     return parent::getImageUser();
    // }

    public function getCurrentJob():?string {
        return $this->currentJob;
    }
    public function setCurrentJob(string $currentJob):self {
        $this->currentJob = $currentJob;
        return $this;
    }

    public function getCompanyName():?string {
        return $this->companyName;
    }
    public function setCompanyName(string $companyName):self {
        $this->companyName = $companyName;
        return $this;
    }
}
