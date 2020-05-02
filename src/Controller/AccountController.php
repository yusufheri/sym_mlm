<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Entity\PasswordUpdate;
use App\Form\RegistrationType;
use App\Form\PasswordUpdateType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/accounts", name="account_index")
     */
    public function index(UserRepository $repo)
    {
        return $this->render('account/index.html.twig', [
            'users' => $repo->findBy(["deletedAt" => null], ["email" => "ASC"]),
        ]);
    }

    /**
     * Permet d'afficher les détails de l'utilisateur en cours
     * @Route("/account", name="account_user")
     *
     * @return Response
     */
    public function account(){
        return $this->render('account/account.html.twig', [
            'user' => $this->getUser()
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
    public function registre(Request $request, EntityManagerInterface $entityManagerInterface, UserPasswordEncoderInterface $encoder){
        
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

    /**
     * Permet de modifier le mot de passe de l'utilisateur en cours
     * 
     * @Route("/account/password-update", name="account_password")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * 
     * @return Response
     */
    public function updatePassword(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder){
        
        $passwordUpdate = new PasswordUpdate();

        $user = $this->getUser();

        if(! is_null($user)){
            $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                if (!(password_verify($passwordUpdate->getOldPassword(), $user->getPassword()))) {
                    //Gérer le password
                    dump('Malheureusement');
                } else {
    
                    $newpassword = $passwordUpdate->getNewPassword();
                    $hash = $encoder->encodePassword($user, $newpassword);
    
                    $user->setHash($hash);
    
                    $manager->persist($user);
                    $manager->flush();
    
                    $this->addFlash(
                        'success',
                        'votre nouveau mot de passe a été enregistré avec succès'
                    );
                    return $this->redirectToRoute('homepage');
                }
            }
            return $this->render('/account/password-update.html.twig',[
                'form' => $form->createView()
            ]);
        } else {
            throw new Exception("Error Processing Request", 1);
            
        }

       

        

        
    }

    /**
     * Permet de modifier le profile de l'utilisateur en cours
     * 
     * @Route("/account/profile", name="account_profile")
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function updateProfile(Request $request, EntityManagerInterface $manager){
        $user = $this->getUser();

        if (! is_null($user)){
            $form = $this->createForm(AccountType::class, $user);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()){
                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    "success",
                    '<h4 class="alert-heading">Parfait !</h4>
                    <p class="mb-0">Les modifications apportées à votre profile ont été enregistrées avec succès. Allez vers <i class="fas fa-sign-out-alt"></i><a href="/dashboard">
                    Dashboard</a></p>'
                );

                //  return $this->redirectToRoute("account_user");
            }
        }
        return $this->render('account/profile.html.twig',[
            'form' => $form->createView()
        ]);
    }

}
