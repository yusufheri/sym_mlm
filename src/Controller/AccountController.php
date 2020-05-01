<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="account_index")
     */
    public function index(UserRepository $repo)
    {
        return $this->render('account/index.html.twig', [
            'users' => $repo->findBy(["deletedAt" => null], ["email" => "ASC"]),
        ]);
    }

    /**
     * @Route("/login", name="account_login")
     */
    public function login(AuthenticationUtils $utils)
    {
        $errors = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();
        return $this->render('account/login.html.twig', [
            'hasErrors' => $errors !== null,
            'username' => $username
        ]);
    }

    /**
     * @Route("/logout", name="account_logout")
     */
    public function logout(AuthenticationUtils $authenticationUtils)
    {
       //   dump($authenticationUtils->getdate();
       dump($authenticationUtils->getLastUsername());
    }


}
