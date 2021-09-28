<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Image;
use App\Entity\Images;
use App\Entity\Message;
use App\Entity\Articles;
use App\Entity\RetourExp;
use App\Entity\Abonnement;
use App\Entity\Commentaire;
use App\Entity\FaQuestions;
use App\Entity\Entrepreneur;
use App\Entity\SecteurActivite;
use App\Controller\Admin\UserCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController {
    /**
     * @Route("/admin", name="admin")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function index():Response {
        //* redirect to some CRUD controller
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(UserCrudController::class)->generateUrl());
    }

    public function configureDashboard():Dashboard {
        return Dashboard::new()
            ->setTitle('Generation Boomerang')
        ;
    }

    public function configureMenuItems():iterable {
        yield MenuItem::linkToRoute('Retour sur le site', 'fa fa-home', 'home');
        yield MenuItem::linkToCrud('Utilisateur', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Abonnement', 'fas fa-pager', Abonnement::class);
        yield MenuItem::linkToCrud('Articles', 'fas fa-newspaper', Articles::class);
        yield MenuItem::linkToCrud('Retour Experience', 'fas fa-flask', RetourExp::class);
        yield MenuItem::linkToCrud('Images', 'fas fa-image', Images::class);
        yield MenuItem::linkToCrud('Image de profil', 'fas fa-image', Image::class);
        yield MenuItem::linkToCrud('Foire aux questions', 'fas fa-comments', FaQuestions::class);
        yield MenuItem::linkToCrud('secteur activité', 'fas fa-comments', SecteurActivite::class);
        yield MenuItem::linkToCrud('Message', 'fas fa-comments', Message::class);
        yield MenuItem::linkToCrud('Commentaire', 'fas fa-comment-dots', Commentaire::class);
        yield MenuItem::linkToLogout('Logout', 'fa fa-sign-out-alt');
    }

    public function configureUserMenu(UserInterface $user):UserMenu {
        return parent::configureUserMenu($user)
            ->setName($user->getFullname())
            ->displayUserAvatar(true);
    }
}