<?php

namespace App\Message;

class GetMessages
{
    private $conversationId;

    public function __construct(int $conversationId) {
        $this->conversationId = $conversationId;
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