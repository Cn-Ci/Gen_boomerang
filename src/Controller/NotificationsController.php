<?php

namespace App\Controller;

use App\Service\NotifService;
use App\Service\SecurityService;
use App\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NotificationsController extends AbstractController {
    /**
     * @Route("/addNotif", name="addNotification")
     */
    public function addNotif(NotifService $notifService, SecurityService $security):Response {
        //* à placer dans la fonction souhaité pour envoie de notifications par mail
        //* $security->getUser() pour envoyer à l'utilisateur connecté 
        //* remplacer par l'autheur d'un article dans la fonction add commentaire ou pour chaque utilisateur dans une conversation (messagerie). 
        //? par exemple : $articles->getAuthor() || foreach sur les users d'une conversation 
        
        $notifService->addNotif(
            $security->getUser(),
            "Ma description de notification"
        );

        return $this->json(
            'Envoi ok'
        );
    }

    /**
     * @Route("/deleteNotif/{id}", name="deleteNotification")
     */
    public function deleteNotif(NotifService $notifService, SecurityService $security, NotificationRepository $repoNotif, Int $id):Response {
        $notifService->RemoveNotif(
            $repoNotif->findOneBy(
                ['id' => $id]
            )
        );
 
        return $this->json(
            'delete ok'
        );
    }
}