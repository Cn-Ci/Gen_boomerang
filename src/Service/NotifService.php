<?php 

namespace App\Service;

use App\Entity\User;
use App\Entity\Notification;
use App\Service\MailerService;
use Doctrine\ORM\EntityManagerInterface;

class NotifService {
    private $mailer;
    private $entityManager;

    public function __construct(MailerService $mailer, EntityManagerInterface $entityManager) {
        $this->mailer        = $mailer;
        $this->entityManager = $entityManager;
    }

    public function addNotif(User $user, String $description) {
        $notif = new Notification();
        $notif
            ->setDescription(
                $description
            )
            ->setUserNotifs(
                $user
            )
        ;

        $user->addNotif($notif);

        $this->mailer->sendEmailNotification(
            $user->getEmail(),
            'Génération Boomerang | Vous avez une nouvelle notification',
            $user->getFullName(),
            '/emails/notificationMail.html.twig'
        );

        $this->entityManager->persist($notif);
        $this->entityManager->flush();

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function RemoveNotif(Notification $notif) {
        $this->entityManager->remove($notif);
        $this->entityManager->flush();
    }
}