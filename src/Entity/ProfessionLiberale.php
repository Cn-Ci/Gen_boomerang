<?php

namespace App\Entity;

use App\Repository\ProfessionLiberaleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfessionLiberaleRepository::class)
 */
class ProfessionLiberale extends User {
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $currentJob;

    /**
     * @ORM\OneToOne(targetEntity=Entreprise::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $company;

    public function getId():?int {
        return parent::getId();
    }

    public function getType():string {
        return 'Profession Liberale';
    }
    public function getTypeWithoutSpecialChart():String {
        return 'professionLiberale';
    }

    public function getCurrentJob():?string {
        return $this->currentJob;
    }
    public function setCurrentJob(string $currentJob):self {
        $this->currentJob = $currentJob;
        return $this;
    }

    public function getCompany():?Entreprise {
        return $this->company;
    }
    public function setCompany(Entreprise $company):self {
        $this->company = $company;
        return $this;
    }
}
