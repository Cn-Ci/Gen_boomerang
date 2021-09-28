<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\NotificationRepository;

/**
 * @ORM\Entity(repositoryClass=NotificationRepository::class)
 */
class Notification {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="notif")
     */
    private $userNotifs;

    public function getId():?int {
        return $this->id;
    }

    public function getDescription():?string {
        return $this->description;
    }
    public function setDescription(string $description):self {
        $this->description = $description;
        return $this;
    }

    public function getUserNotifs():?User {
        return $this->userNotifs;
    }
    public function setUserNotifs(?User $userNotifs):self {
        $this->userNotifs = $userNotifs;
        return $this;
    }
}
