<?php

namespace App\Entity;

use App\Repository\UserNewsletterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserNewsletterRepository::class)
 */
class UserNewsletter
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180,unique=true)
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_rgpd;

    /**
     * @ORM\ManyToMany(targetEntity=Pole::class, inversedBy="userNewsletter")
     */
    private $poles;

    public function __construct()
    {
        $this->poles = new ArrayCollection();
        $this->created_at = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getIsRgpd(): ?bool
    {
        return $this->is_rgpd;
    }

    public function setIsRgpd(bool $is_rgpd): self
    {
        $this->is_rgpd = $is_rgpd;

        return $this;
    }

    /**
     * @return Collection|Pole[]
     */
    public function getPoles(): Collection
    {
        return $this->poles;
    }

    public function addPole(Pole $pole): self
    {
        if (!$this->poles->contains($pole)) {
            $this->poles[] = $pole;
        }

        return $this;
    }

    public function removePole(Pole $pole): self
    {
        $this->poles->removeElement($pole);

        return $this;
    }
}
