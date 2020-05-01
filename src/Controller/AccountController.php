<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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
     * Permet de connecter un utilisateur
     * 
     * @Route("/login", name="account_login")
     * 
     * @return Response
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
     * Permet de déconnecter un utilisateur
     * 
     * @Route("/logout", name="account_logout")
     */
    public function logout(AuthenticationUtils $authenticationUtils)
    {
       //   dump($authenticationUtils->getdate();
       dump($authenticationUtils->getLastUsername());
    }

    /**
     * Permet d'enregistrer un nouvel utilisateur
     * 
     * @Route("/registre", name="account_registre")
     * 
     * @return Response
     */
    public function registre(Request $request, EntityManagerInterface $entityManagerInterface, 
    UserPasswordEncoderInterface $encoder){
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $hash = $encoder->encodePassword($user, $user->getHash());
            $user->setHash($hash);

            $token = $request->request->get('_csrf_token');

            if($this->isCsrfTokenValid("authenticate",$token)){
                $entityManagerInterface->persist($user);
                $entityManagerInterface->flush();
    
                $this->addFlash(
                    "success",
                    '<h4 class="alert-heading">Félicitations !</h4>
                    <p class="mb-0">Votre compte a été créé avec succès, <a href="/login">connectez-vous maintenant</a> :)</p>'
                );
                return $this->redirect($request->getUri());
            } else {
                $this->addFlash(
                    "danger",
                    '<h4 class="alert-heading">Avertissement !</h4>
                    <p class="mb-0">Le jeton envoyé n est pas  valide, prière de contacter l administrateur</p>'
                );
            }

           
            
        }

        return $this->render('account/registre.html.twig', [
                'form' => $form->createView()
        ]
    );
    }


}
