<?php

namespace App\Entity;

use App\Repository\ConversationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConversationRepository::class)
 */
class Conversation {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Message::class, cascade={"persist", "remove"})
     */
    private $lastMessage;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="conversation")
     */
    private $messages;

    /**
     * @ORM\OneToMany(targetEntity="Participant", mappedBy="conversation")
     */
    private $participants;

    /**
     * @ORM\Column(type="string" , length=50)
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct() {
        $this->participants = new ArrayCollection();
        $this->messages     = new ArrayCollection();
        $this->createdAt    = new \DateTime('now');
    }

    public function getId():?int {
        return $this->id;
    }

    public function getLastMessage():?Message {
        return $this->lastMessage;
    }
    public function setLastMessage(?Message $lastMessage):self {
        $this->lastMessage = $lastMessage;
        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages():Collection {
        return $this->messages;
    }
    public function addMessage(Message $message):self {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setConversation($this);
        }
        return $this;
    }
    public function removeMessage(Message $message):self {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getConversation() === $this) {
                $message->setConversation(null);
            }
        }
        return $this;
    }

     /**
     * @return Collection|Participant[]
     */
    public function getParticipants():Collection {
        return $this->participants;
    }

    public function addParticipant(Participant $participant):self {
        if (!$this->participants->contains($participant)) {
            $this->participants[] = $participant;
            $participant->setConversation($this);
        }
        return $this;
    }
    public function removeParticipant(Participant $participant):self {
        if ($this->participants->contains($participant)) {
            $this->participants->removeElement($participant);
            // set the owning side to null (unless already changed)
            if ($participant->getConversation() === $this) {
                $participant->setConversation(null);
            }
        }
        return $this;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle() {
        return $this->title;
    }
    /**
     * Set the value of title
     * @return  self
     */ 
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function getCreatedAt():?\DateTimeInterface {
        return $this->createdAt;
    }
    public function setCreatedAt(\DateTimeInterface $createdAt):self {
        $this->createdAt = $createdAt;
        return $this;
    }
}
