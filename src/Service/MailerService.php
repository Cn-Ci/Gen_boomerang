<?php 

namespace App\Service;

use App\Entity\User;
use Doctrine\DBAL\Exception\DriverException;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\Security;

class MailerService {
    private $mailer;

    public function __construct(MailerInterface $mailer) {
        $this->mailer = $mailer;
    }

    public function sendEmail(String $receiver, String $subject, String $template, String $username) {
        try {
            $email = (new TemplatedEmail())
                ->from('gen@generation-boomerang.com')
                ->to($receiver)
                ->subject($subject)
                ->htmlTemplate($template)
                ->context([
                    'username' => $username,
                ])
            ;
    
            $this->mailer->send($email);
        } catch (DriverException $e) {
            $e->getMessage();
        }
    }

    public function sendEmailNotification(String $receiver, String $subject, String $username,String $htmlTemplate) {
        try {
            $email = (new TemplatedEmail())
                ->from('gen@generation-boomerang.com')
                ->to($receiver)
                ->subject($subject)
                ->htmlTemplate($htmlTemplate)
                ->context([
                    'username' => $username,
                ])
            ;
    
            $this->mailer->send($email);
        } catch (DriverException $e) {
            $e->getMessage();
        }
    }

    public function sendNewsletter(Array $users, String $template, Array $context) {
        try {
            foreach ($users as $user) {
                $email = (new TemplatedEmail())
                    ->from('gen@generation-boomerang.com')
                    ->to($user->getEmail())
                    ->subject("Du nouveau dans votre newsletter !")
                    ->htmlTemplate($template)
                    ->context([
                        'titleOne'   => $context[0],
                        'titre2'   => $context[1],
                        'desc1'    => $context[2],
                        'desc2'    => $context[3],
                        'username' => $user->getFullName(),
                    ])
                ;
                
                $this->mailer->send($email);
            }
        } catch (DriverException $e) {
            $e->getMessage();
        }
    }
}