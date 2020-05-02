<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AccountType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, $this->getConfiguration("Prénom de l'utilisateur", "Tapez le prénom de l'utilisateur"))
            ->add('lastname', TextType::class, $this->getConfiguration("Nom de l'utilisateur", "Tapez le nom de l'utilisateur"))
            ->add('email', TextType::class, $this->getConfiguration("Email de l'utilisateur", "Tapez le mail de l'utilisateur"))
            ->add('description', TextareaType::class, $this->getConfiguration("Description de l'utilisateur", "Parlez nous un peu de Vous."))
            ->add('imageFile', FileType::class, $this->getConfiguration("Votre photo de profile", "Votre photo de profile", ["required" => false]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
