<?php

namespace App\Message;

use App\Entity\User;
use App\Entity\Conversation;

class CreateMessage
{
    private $content;
    private $userId;
    private $conversationId;

    public function __construct(string $content, int $userId, int $conversationId) {
        $this->content = $content;
        $this->userId = $userId;
        $this->conversationId = $conversationId;
    }

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Get the value of userId
     */ 
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @return  self
     */ 
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * Get the value of conversationId
     */ 
    public function getConversationId()
    {
        return $this->conversationId;
    }

    /**
     * Set the value of conversationId
     *
     * @return  self
     */ 
    public function setConversationId($conversationId)
    {
        $this->conversationId = $conversationId;
        return $this;
    }
}
