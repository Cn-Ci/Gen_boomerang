<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Message;
use App\Entity\Participant;
use App\Entity\Conversation;
use App\Message\CreateMessage;
use App\Repository\UserRepository;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ParticipantRepository;
use App\Repository\ConversationRepository;
use App\Controller\Mercure\CookieGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Messenger\MessageBusInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChatController extends AbstractController {
    /**
     * @Route("/messagerie/newMessage", name="messagerie_newMessage" , methods={"POST" , "GET"})
     * @Security("is_granted('ROLE_ABONNE') or is_granted('ROLE_ADMIN')", message="Merci de vous abonner au portail pour bénéficier de cette super fonctionnalité !")
     */
    public function newMessage(Request $request, MessageBusInterface $messageBus) {
        //* Récup du user + check à faire
        $userEncours = $this->getUser();
        $userId = $userEncours->getId();
        if ($request->isMethod('POST')) {
            //* Vérif si user est bien connecté
            if ($this->getUser() !== null) {
                $donneesJson = file_get_contents('php://input');
                $donnees     = json_decode($donneesJson);

                //* Verif si message non vide
                if (isset($donnees->message) && !empty($donnees->message)) {
                    $messageBus->dispatch(
                        $mess = new CreateMessage(
                            $donnees->message,
                            $userId,
                            $donnees->conversationId
                        )
                    );

                    return $this->json([
                        'message' => 'Add ok'
                    ]);
                } else {
                    return $this->json([
                        'message' => 'KO Votre message est vide'
                    ]);
                }
            } else {
                return $this->json([
                    'message' => 'Vous devez être connecté pour ajouter un message'
                ]);
            }
        } else {
            return $this->json([
                'message' => 'Internal server error ( WRONG METHOD )'
            ]);
        }
    }

    /**
     * @Route("/messagerie/newConv" , name="messagerie_newConv")
     * @Security("is_granted('ROLE_ABONNE') or is_granted('ROLE_ADMIN')", message="Merci de vous abonner au portail pour bénéficier de cette super fonctionnalité !")
     */
    public function newConv(EntityManagerInterface $entityManager , UserRepository $userRepository) {
        $allUsersExceptAdmin = $userRepository->findAllExceptAdmin();

        return $this->render('messagerie/new.html.twig', [
            'users' => $allUsersExceptAdmin,
        ]);
    }

    /**
     * @Route("/messagerie/createConv" , name="messagerie_createConversation" , methods={"POST"})
     */
    public function createConversation(Request $request, EntityManagerInterface $entityManager, MessageBusInterface $messageBus) {
        //* Get id of the current user connected
        $userId = $this->getUser()->getId();

        //* Check id method is equal to (POST)
        if ($request->isMethod('POST')) {
            $donneesConvJson = file_get_contents('php://input');
            $donneesConv     = json_decode($donneesConvJson);
            
            //* Check if content is defined
            if (isset($donneesConv->listeParticipants) && !empty($donneesConv->listeParticipants)) {
                //* Creation of a new Conv
                $conversation = new Conversation();
                $conversation->setTitle($donneesConv->groupName);
                $entityManager->persist($conversation);
                $entityManager->flush();
                
                //* Get list of all user in the coversation created
                $usersConv = new ArrayCollection($donneesConv->listeParticipants);

 
                //* We add the current user in the list
                $usersConv->add($userId);
                
                //* Add conv to all user in the list
                foreach ($usersConv as $user) {
                    $user = $entityManager->getRepository(User::class)->find((int)$user);
                    
                    $participant = new Participant();
                    $participant->setConversation($conversation);
                    $participant->setUser($user);

                    //* Persist in DB
                    $entityManager->persist($participant);
                    $entityManager->flush();
                }
                
                //* Send the message to all user in the conversation
                $messageBus->dispatch(new CreateMessage(
                    $donneesConv->message,
                    $userId,
                    $conversation->getId()
                ));
            } else {
                return $this->json(
                    'KO'
                );
            }
        } else {
            return $this->json(
                'failed'
            );
        }

        return $this->json(
            'Conversation ajoutée'
        );
    }

    /**
     * @Route("/messagerie/conv/{id}" , name="messagerie_getMessagesOfConv")
     * @Security("is_granted('ROLE_ABONNE') or is_granted('ROLE_ADMIN')", message="Merci de vous abonner au portail pour bénéficier de cette super fonctionnalité !")
     */
    public function getMessagesOfConv(int $id, EntityManagerInterface $entityManager, ConversationRepository $conversationRepository, ParticipantRepository $participantRepository) {
        //* Récup du user + check à faire
        $userEncours = $this->getUser();
        $userId = $userEncours->getId();

        //* Ckeck si la conversation appartient bien au user
        $check = $participantRepository->checkBelongs($id, $userId);
        if ($check != 1) {
            return $this->json('cette conv ne te regarde pas !');
        }

        $conversation = $conversationRepository->find($id);
        $messages = $conversation->getMessages();

        $allMessages = new ArrayCollection();
        foreach ($messages as $messageUnique) {
            $conversation
                ->setLastMessage(
                    $messageUnique
                )
            ;

            $messageUnique = array(
                'id'        => $messageUnique->getId(),
                'author'    => $messageUnique->getUser()->getFullName(),
                'authorId'  => $messageUnique->getUser()->getId(),
                'content'   => $messageUnique->getContent(),
                'createdAt' => $messageUnique->getCreatedAt()
            );
            $allMessages->add($messageUnique);
        }

        $entityManager->persist($conversation);
        $entityManager->flush();

        return $this->json($allMessages);
    }

    /**
     * @Route("/messagerie/all" , name="messagerie_getConversations")
     * @Security("is_granted('ROLE_ABONNE') or is_granted('ROLE_ADMIN')", message="Merci de vous abonner au portail pour bénéficier de cette super fonctionnalité !")
     */
    public function getConvs(EntityManagerInterface $entityManager, ConversationRepository $conversationRepository, ParticipantRepository $participantRepository) {
        //* Récup du user + check à faire
        $userEncours = $this->getUser();
        $userId = $userEncours->getId();

        //* Afficher toutes les conversations du user
        $conversations = $conversationRepository->findUserConversations($userId);
        $conversationsTotal = new ArrayCollection();

        foreach ($conversations as $conversationUnique) {
            $allParticipants = $participantRepository->findBy(['conversation' => $conversationUnique->getId()]);
            $tabParticipants = new ArrayCollection();

            foreach ($allParticipants as $participant) {
                $tabParticipants->add($participant->getUser());
            }

            $conversationUnique = array(
                'participants' => $tabParticipants,
                'id'           => $conversationUnique->getId(),
                'title'        => $conversationUnique->getTitle(),
                'createdAt'    => $conversationUnique->getCreatedAt()
            );

            $conversationsTotal->add($conversationUnique);
        }

        return $this->render('messagerie/index.html.twig', [
            'controller_name' => 'ChatController',
            'conversations' => $conversationsTotal,
        ]);
    }

    /**
     * @Route("/messagerie/delete/{id}" , name="messagerie_deleteConversation")
     * @Security("is_granted('ROLE_ABONNE') or is_granted('ROLE_ADMIN')", message="Merci de vous abonner au portail pour bénéficier de cette super fonctionnalité !")
     */
    public function deleteConv(int $id, EntityManagerInterface $entityManager) {
        //* Récup du user + check à faire
        $userEncours = $this->getUser();
        $userId = $userEncours->getId();

        //* Le user en cours veut se retirer de la conversation (participants) != supprimer
        //* On vérifie l'id envoyé via variable de chemin est valide
        if ($id != null && is_int($id)) {
            //On récup la participation
            $participation = $entityManager->getRepository(Participant::class)->findOneBy(['conversation' => $id, 'user' => $userId]);

            $entityManager->remove($participation);
            $entityManager->flush();
        }
        return $this->json('');
    }

    /**
     * @Route("/checkMessage/{idMessage}", name="checkLastMessage")
     */
    public function checkLastMessage(Message $idMessage, MessageRepository $messRepo) {
        $message     = $messRepo->findOneBy(['id' => $idMessage]);
        $lastMessage = $message->getConversation()->getLastMessage();

        if ($message->getId() != $lastMessage->getId()) {
            return $this->json(true);
        }

        //* Return false if there is no new message
        return $this->json(false);
    }

    /**
     * @Route("/chat", name="chat")
     */
    public function __invoke(CookieGenerator $cookieGenerator):Response {
        $response = $this->render('messagerie/chat.html.twig', []);
        $response->headers->setCookie($cookieGenerator->generate());

        return $response;
    }
}