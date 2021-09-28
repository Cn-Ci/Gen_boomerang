<?php

namespace App\Entity;

use App\Repository\NewsletterNotConnectedRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NewsletterNotConnectedRepository::class)
 */
class NewsletterNotConnected
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array")
     */
    private $email = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?array
    {
        return $this->email;
    }

    public function setEmail(?array $email): self
    {
        $this->email = $email;

        return $this;
    }
}
