<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegistrationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, $this->getConfiguration("Nom de l'utilisateur", "Tapez le nom du nouvel utilisateur"))
            ->add('lastname', TextType::class, $this->getConfiguration("Post nom de l'utilisateur", "Tapez le post nom du nouvel utilisateur"))            
            ->add('email', EmailType::class, $this->getConfiguration("Email", "Introduire l'adresse mail"))
            ->add('hash', PasswordType::class, $this->getConfiguration("Mot de passe", "Introduire le mot de passe"))
            ->add('confirmPassword', PasswordType::class, $this->getConfiguration("Confirmer le mot de passe", "Confirmer votre mot de passe"))
            ->add('description', TextareaType::class, $this->getConfiguration("Decrivez l'utilisateur", "Petite description de l'utilisateur"))
            ->add('imageFile', FileType::class, $this->getConfiguration("Votre avatar", "",["required" => false]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
