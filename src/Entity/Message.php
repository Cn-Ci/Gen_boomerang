<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
    * @ORM\ManyToOne(targetEntity=Conversation::class, inversedBy="messages")
    */
    private $conversation; 

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messages")
     */
    private $user;

    public function __construct( string $content, User $user, Conversation $converstation) {
        $this->content      = $content;
        $this->user         = $user;
        $this->conversation = $converstation;
        $this->createdAt    = new \DateTime('now');
    }

    public function getId():?int {
        return $this->id;
    }

    public function getContent():?string {
        return $this->content;
    }
    public function setContent(string $content):self {
        $this->content = $content;
        return $this;
    }

    public function getCreatedAt():?\DateTimeInterface {
        return $this->createdAt;
    }
    public function setCreatedAt(\DateTimeInterface $createdAt):self {
        $this->createdAt = $createdAt;
        return $this;
    }
    
    public function getConversation():?Conversation
    {
        return $this->conversation;
    }
    public function setConversation(?Conversation $conversation):self {
        $this->conversation = $conversation;
        return $this;
    }

    public function getUser():?User {
        return $this->user;
    }
    public function setUser(?User $user):self {
        $this->user = $user;
        return $this;
    }
}
