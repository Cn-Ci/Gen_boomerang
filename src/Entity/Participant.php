<?php

namespace App\Entity;

use App\Repository\ParticipantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParticipantRepository::class)
 */
class Participant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="participants")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Conversation", inversedBy="participants")
     */
    private $conversation;

    private $messageReadAt;

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of user
     */ 
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */ 
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get the value of conversation
     */ 
    public function getConversation()
    {
        return $this->conversation;
    }

    /**
     * Set the value of conversation
     *
     * @return  self
     */ 
    public function setConversation($conversation)
    {
        $this->conversation = $conversation;
        return $this;
    }

    /**
     * Get the value of messageReadAt
     */ 
    public function getMessageReadAt()
    {
        return $this->messageReadAt;
    }

    /**
     * Set the value of messageReadAt
     *
     * @return  self
     */ 
    public function setMessageReadAt($messageReadAt)
    {
        $this->messageReadAt = $messageReadAt;
        return $this;
    }
}
