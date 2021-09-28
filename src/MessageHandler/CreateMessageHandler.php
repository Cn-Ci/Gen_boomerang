<?php

namespace App\MessageHandler;
use App\Entity\User;
use App\Entity\Message;
use App\Entity\Conversation;
use App\Message\CreateMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateMessageHandler implements MessageHandlerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function __invoke(CreateMessage $createMessage) 
    {
        $conversation = $this->entityManager->getRepository(Conversation::class)->find($createMessage->getConversationId());

        if(is_null($conversation))
        {
            $conversation = new Conversation();
            $this->entityManager->persist($conversation);
            $this->entityManager->flush();
        } else {
            $message = new Message(
                $createMessage->getContent(),
                $this->entityManager->getRepository(User::class)->find($createMessage->getUserId()),
                $conversation,
            );
        }

        // Debug
        // echo $createMessage->getContent();
        // echo $message->getUser()->getId();
        // echo $message->getConversation()->getId();

        $this->entityManager->persist($message);
        $this->entityManager->flush();
    }
}