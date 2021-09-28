<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EntrepreneurRepository;

/**
 * @ORM\Entity(repositoryClass=EntrepreneurRepository::class)
 */
class Entrepreneur extends User {
    /**
     * @ORM\OneToOne(targetEntity=Entreprise::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $company;

    private $image;

    public function getId():?int {
        return parent::getId();
    }

    public function getType():string {
        return 'Entrepreneur';
    }
    public function getTypeWithoutSpecialChart():String {
        return 'entrepreneur';
    }

    public function getImage(){
        return parent::getAvatar();
    }

    public function getCompany():?Entreprise {
        return $this->company;
    }
    public function setCompany(Entreprise $company):self {
        $this->company = $company;
        return $this;
    }
}
