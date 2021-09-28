<?php

namespace App\MessageHandler;

use App\Entity\Message;
use App\Message\GetMessages;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetMessagesHandler implements MessageHandlerInterface
{
    private $entityManager;
    private $messageRepository;

    public function __construct(EntityManagerInterface $entityManager, MessageRepository $messageRepository) {
        $this->entityManager = $entityManager;
    }

    public function __invoke(GetMessages $message)
    {
        //Récupérer les messages de la conversation
        return $this->entityManager->getRepository(Message::class)->findBy(['conversation' => $message->getConversationId()]);
    }
}